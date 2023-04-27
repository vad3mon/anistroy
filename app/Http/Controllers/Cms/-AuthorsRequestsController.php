<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AuthorRequest;
use App\Models\AuthorRequestFile;
use App\Models\EditorTag;
use App\Models\EditorReadResult;
use App\Models\EditorReadDecision;
use App\Models\EditorReadComment;
use App\Models\EditorReadTag;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthorsRequestsController extends Controller
{
    public function authorsList()
    {
        $requestsFromAuthors = AuthorRequest::orderBy('id', 'desc')->get();

        foreach ($requestsFromAuthors as $authorRequest) {

            $requestsFromAuthorsResults[$authorRequest->id] = 0;
            $requestsFromAuthorsResultsCount[$authorRequest->id] = 0;

            $requestFromAuthorFiles = AuthorRequestFile::where('author_request_id', $authorRequest->id)->get();

            foreach ($requestFromAuthorFiles as $file) {

                $requestResults = EditorReadResult::where('author_file_id', $file->id)
                    ->get();


                foreach ($requestResults as $result) {
                    $requestsFromAuthorsResults[$authorRequest->id] += $result->result;
                    $requestsFromAuthorsResultsCount[$authorRequest->id]++;
                }

                if ($requestsFromAuthorsResultsCount[$authorRequest->id]) {
                    $requestsFromAuthorsResults[$authorRequest->id] /= $requestsFromAuthorsResultsCount[$authorRequest->id];
                }
            }


        }

        return view('admin.authors-requests-list', compact(
            'requestsFromAuthors',
            'requestsFromAuthorsResultsCount',
            'requestsFromAuthorsResults'
        ));
    }


    public function authorsItem($id)
    {

        $user = Auth::user();

        $editorsTags = EditorTag::all()->groupBy('type');

        $requestFromAuthor = AuthorRequest::where('id', $id)->first();

        $requestFromAuthorFiles = AuthorRequestFile::where('author_request_id', $id)->get();

        $results = [];
        $resultTags = [];
        foreach ($requestFromAuthorFiles as $file) {
            $results[$file->id] = [];
            $tags[$file->id] = [];

            $requestResults = EditorReadResult::select('editor_read_results.result as result', 'users.name as user_name')
                ->where('author_file_id', $file->id)
                ->join('users', 'editor_read_results.user_id', '=', 'users.id')
                ->get();

            foreach ($requestResults as $result) {
                $results[$file->id][] = $result;
            }

            $requestTags = EditorReadTag::select('editor_read_tags.tag_id as tag_id', 'users.name as user_name')
                ->where('author_file_id', $file->id)
                ->join('users', 'editor_read_tags.user_id', '=', 'users.id')
                ->get();

            foreach ($requestTags as $tag) {
                if (!isset($resultTags[$file->id][$tag->tag_id])) {
                    $resultTags[$file->id][$tag->tag_id] = [];
                }
                $resultTags[$file->id][$tag->tag_id][] = $tag;
            }

        }

        return view('admin.authors-requests-item', compact(
            'user',
            'requestFromAuthor',
            'requestFromAuthorFiles',
            'editorsTags',
            'results',
            'resultTags'
        ));
    }

    public function authorsItemVote($id, Request $request)
    {
        $user = Auth::user();

        AuthorRequest::where('id', $id)
            ->update([
                'exported' => $request->exported ? 1 : 0,
                'email_sent' => $request->email_sent ? 1 : 0,
                'email_sent_type' => $request->email_sent_type,
                'author_checked' => $request->author_checked ? 1 : 0,
            ]);

        // апдейтим слово главного редактора
        if ($user->rights == 'chief_editor' || $user->rights == 'omni') {
            if ($request->chief_editor_mark) {
                AuthorRequest::where('id', $id)
                    ->update(['chief_editor_mark' => $request->chief_editor_mark]);
            }
        }

        return redirect()->route('admin_authors');
    }

    public function filesList(Request $request)
    {

        $user = Auth::user();

        $authorRequestFiles = AuthorRequestFile::orderBy('id', 'desc');

        if ($request->input('search')) {
            $authorRequestFiles = $authorRequestFiles->where('author_request_files.name', 'like', '%' . $request->input('search') . '%');
        }

        if ($request->input('big')) {
            $authorRequestFiles = match ($request->input('big')) {
                'no_big' => $authorRequestFiles->where('author_request_files.is_big', '0'),
                'only_big' => $authorRequestFiles->where('author_request_files.is_big', '1')
            };
        }

        if ($request->input('chief')) {
            $authorRequestFiles = match ($request->input('chief')) {
                'yes' => $authorRequestFiles->where('author_request_files.chief_editor_mark', 'yes'),
                'no' => $authorRequestFiles->where('author_request_files.chief_editor_mark', 'no'),
                'think' => $authorRequestFiles->where('author_request_files.chief_editor_mark', 'think')
            };
        }

        if ($request->input('interesting')) {
            $authorRequestFiles = $authorRequestFiles->where('author_request_files.interesting', '1');
        }

        if ($request->input('voted')) {
            $allVotes = DB::table('editor_read_results')->select('author_file_id')->where('user_id', $user->id)
                ->get()->pluck('author_file_id');

            $authorRequestFiles = match ($request->input('voted')) {
                'yes' => $authorRequestFiles->whereIn('author_request_files.id', $allVotes),
                'no' => $authorRequestFiles->whereNotIn('author_request_files.id', $allVotes)
            };
        }

        $authorRequestFiles = $authorRequestFiles
            ->leftjoin('editor_read_results', function ($join) use ($user) {
                $join->on('author_request_file_id', '=', 'author_request_files.id')
                    ->where('user_id', $user->id);
            })
            ->leftjoin('author_requests', 'author_requests.id', '=', 'author_request_files.author_request_id')
            ->select('author_request_files.*', 'author_requests.name as author', 'editor_read_results.result as result')
            ->get();

        return view('admin.authors-files-list', compact(
            'user',
            'authorRequestFiles',
            'request'
        ));
    }

    public function filesItem($id)
    {

        $user = Auth::user();

        $authorRequestFile = AuthorRequestFile::where('author_request_files.id', $id)
            ->join('author_requests', 'author_requests.id', '=', 'author_request_files.author_request_id')
            ->leftjoin('editor_read_results', function ($join) use ($user) {
                $join->on('author_file_id', '=', 'author_request_files.id')
                    ->where('user_id', '=', $user->id);
            })
            ->select('author_request_files.*',
                'author_requests.name as author',
                'author_requests.id as author_id',
                'author_requests.contacts as author_contacts',
                'author_requests.about as author_about',
                'editor_read_results.result as result')
            ->first();

        $prevFile = AuthorRequestFile::where('id', '<', $id)
            ->where('is_big', 0)
            ->orderBy('id', 'desc')
            ->first();

        $nextFile = AuthorRequestFile::where('id', '>', $id)
            ->where('is_big', 0)
            ->orderBy('id', 'asc')
            ->first();

        $editorsTags = EditorTag::all()
            ->groupBy('type');

        $editorTagsResult = EditorReadTag::where('author_file_id', '=', $id)
            ->where('user_id', '=', $user->id)
            ->where('deleted', 0)
            ->get();

        $editorComments = EditorReadComment::where('author_file_id', '=', $id)
            ->join('users', 'users.id', '=', 'editors_read_comments.user_id')
            ->select('users.name as username', 'editors_read_comments.*')
            ->get();

        $comment = '';
        foreach ($editorComments as $oneComment) {
            if ($oneComment->user_id == $user->id) {
                $comment = $oneComment->comment;
            }
        }

        $editorDecisions = EditorReadDecision::where('author_file_id', '=', $id)
            ->join('users', 'users.id', '=', 'editors_read_decisions.user_id')
            ->select('users.name as username', 'editors_read_decisions.*')
            ->get();

        $decision = '';
        foreach ($editorDecisions as $oneDecision) {
            if ($oneDecision->user_id == $user->id) {
                $decision = $oneDecision->decision;
            }
        }

        $tagResults = [];
        foreach ($editorTagsResult as $result) {
            $tagResults[$result['tag_id']] = 1;
        }

        return view('admin.authors-files-item', compact(
            'user',
            'authorRequestFile',
            'editorsTags',
            'editorComments',
            'comment',
            'editorDecisions',
            'decision',
            'tagResults',
            'prevFile',
            'nextFile',
        ));
    }

    public function filesItemVote($id, Request $request)
    {
        $user = Auth::user();

        // апдейтим голосование
        if (isset($request->personal_vote)) {
            $readResults = EditorReadResult::where('author_file_id', $id)
                ->where('user_id', $user->id)
                ->first();

            if (!$readResults) {
                $readResults = new EditorReadResult();
            }

            $readResults->user_id = $user->id;
            $readResults->author_file_id = $id;
            $readResults->result = $request->personal_vote;
            $readResults->save();
        }

        // сохраняем комментарий
        if (isset($request->comment)) {
            $readComments = EditorReadComment::where('author_file_id', $id)
                ->where('user_id', $user->id)
                ->first();

            if (!$readComments) {
                $readComments = new EditorReadComment();
            }

            $readComments->user_id = $user->id;
            $readComments->author_file_id = $id;
            $readComments->comment = $request->comment;
            $readComments->save();
        }


        // сохраняем решение о пуьлкации
        if ($request->decision) {
            $readDecision = EditorReadDecision::where('author_file_id', $id)
                ->where('user_id', $user->id)
                ->first();

            if (!$readDecision) {
                $readDecision = new EditorReadDecision();
            }

            $readDecision->user_id = $user->id;
            $readDecision->author_file_id = $id;
            $readDecision->decision = $request->decision;
            $readDecision->save();
        }


        // апдейтим теги
        EditorReadTag::where('author_file_id', $id)
            ->where('user_id', $user->id)
            ->update(['deleted' => 1]);

        if (isset($request->tag)) {
            foreach ($request->tag as $tagId => $tag) {
                $readTag = EditorReadTag::where('tag_id', $tagId)
                    ->where('user_id', $user->id)
                    ->where('author_file_id', $id)
                    ->first();

                if (!$readTag) {
                    $readTag = new EditorReadTag();
                }

                $readTag->user_id = $user->id;
                $readTag->author_file_id = $id;
                $readTag->tag_id = $tagId;
                $readTag->deleted = 0;
                $readTag->save();
            }
        }

        // апдейтим выгрузку на портал и другие пометки
        AuthorRequestFile::where('id', $id)
            ->update([
                'is_big' => ($request->is_big ? '1' : '0'),
                'exported' => ($request->exported ? '1' : '0'),
                'interesting' => ($request->interesting ? '1' : '0'),
            ]);

        // апдейтим слово главного редактора
        if ($user->rights == 'chief_editor' || $user->rights == 'omni') {
            if ($request->chief_editor_mark) {
                AuthorRequestFile::where('id', $id)
                    ->update(['chief_editor_mark' => $request->chief_editor_mark]);
            }
        }

        $nextFile = AuthorRequestFile::where('id', '>', $id)
            ->where('is_big', 0)
            ->first();

        if ($nextFile) {
            return redirect()->route('admin_authors_files_item', $nextFile->id);
        }

        return redirect()->route('admin_authors_files');
    }
}
