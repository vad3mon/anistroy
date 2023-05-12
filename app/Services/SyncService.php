<?php

namespace App\Services;

use App\Models\Category;
use App\Models\MCsync;
use App\Models\Order;
use App\Models\OrderCustomer;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Property;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SyncService
{
    function setAttributes($product_id, $attributes)
    {

        $product = Product::find($product_id);
        if(isset($product->category)) {
            $category = Category::find($product->category->id);

            if ($attributes['name'] == "Характеристики")
            {
                $values = [];
                $ids = [];
                $stringData = explode("\n", $attributes['value']);

                foreach ($stringData as $rowData)
                {
                    if($rowData) {
                        list($key, $value) = explode("=", $rowData);
                        $property = Property::updateOrCreate(
                            ['title' => $key],
                            // ['type' => 'list']
                        );

                        $values[$property->id] = ['value' => $value];
                        $ids[] = $property->id;
                    }
                }

                $product->properties()->sync($values);
                $category->properties()->sync($ids);
            }
        }

    }
    function msGetProductUom($uom_link) {

        $authorization = 'Authorization: Basic ' . base64_encode('it@torg-dom' . ':' . '12345-IT');

        // UOM
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $uom_link);
        curl_setopt($ch, CURLOPT_CAINFO, base_path('cacert-2023-01-10.pem'));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $result = curl_exec($ch);
        curl_close($ch);

        $uom_json = json_decode($result, true);

        return isset($uom_json['name']) ? $uom_json['name'] : '';

    }

    function msGetProductImages($images_link, $product_ms_id) {
        $return_result = array();

        $authorization = 'Authorization: Basic ' . base64_encode('it@torg-dom' . ':' . '12345-IT');

        // images
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $images_link);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization));
        curl_setopt($ch, CURLOPT_CAINFO, base_path('cacert-2023-01-10.pem'));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $result = curl_exec($ch);
        curl_close($ch);

        $images_list_json = json_decode($result, true);


        //        $images_dir = $_SERVER['DOCUMENT_ROOT'] . '/images/products/' . $product_ms_id;

        $images_dir = storage_path('images/products');

        //        if(!file_exists($images_dir )) {
        //            mkdir($images_dir, 0777, true);
        //        }

        if(isset($images_list_json['rows'])) {
            foreach($images_list_json['rows'] as $image) {
                $ch_image = curl_init();
                curl_setopt($ch_image, CURLOPT_URL, $image['meta']['downloadHref']);
                curl_setopt($ch_image, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization));
                curl_setopt($ch, CURLOPT_CAINFO, base_path('cacert-2023-01-10.pem'));
                curl_setopt($ch_image, CURLOPT_CUSTOMREQUEST, 'GET');
                curl_setopt($ch_image, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch_image, CURLOPT_FOLLOWLOCATION, 1);
                $result = curl_exec($ch_image);
                curl_close($ch_image);

                if(!file_exists($images_dir . '/' . $image['filename'])) {
                    Storage::put('public/products/' . $image['filename'], $result);
                }

                $return_result[] = $image['filename'];

            }
        }

        return $return_result;
    }

    function phoneFormat($phone) {
        $phone = trim($phone);

        $res = preg_replace(
            array(
                '/[\+]?([7|8])[-|\s]?\([-|\s]?(\d{3})[-|\s]?\)[-|\s]?(\d{3})[-|\s]?(\d{2})[-|\s]?(\d{2})/',
                '/[\+]?([7|8])[-|\s]?(\d{3})[-|\s]?(\d{3})[-|\s]?(\d{2})[-|\s]?(\d{2})/',
                '/[\+]?([7|8])[-|\s]?\([-|\s]?(\d{4})[-|\s]?\)[-|\s]?(\d{2})[-|\s]?(\d{2})[-|\s]?(\d{2})/',
                '/[\+]?([7|8])[-|\s]?(\d{4})[-|\s]?(\d{2})[-|\s]?(\d{2})[-|\s]?(\d{2})/',
                '/[\+]?([7|8])[-|\s]?\([-|\s]?(\d{4})[-|\s]?\)[-|\s]?(\d{3})[-|\s]?(\d{3})/',
                '/[\+]?([7|8])[-|\s]?(\d{4})[-|\s]?(\d{3})[-|\s]?(\d{3})/',
            ),

            array(

                '+7 $2 $3-$4-$5',

                '+7 $2 $3-$4-$5',

                '+7 $2 $3-$4-$5',

                '+7 $2 $3-$4-$5',

                '+7 $2 $3-$4',

                '+7 $2 $3-$4',

            ),

            $phone

        );
        return $res;

    }

    function addCustomer($name, $phone, $email, $address) {
        $customer_data = [
            'name' => $name,
            'phone' => self::phoneFormat($phone),
            'email'   => $email,
            'actualAddress'   => $address,
            'tags' => ['покупатель']
        ];

        $authorization = 'Authorization: Basic ' . base64_encode('it@torg-dom' . ':' . '12345-IT');

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://online.moysklad.ru/api/remap/1.2/entity/counterparty');

        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $authorization));
        curl_setopt($ch, CURLOPT_CAINFO, base_path('cacert-2023-01-10.pem'));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($customer_data, JSON_UNESCAPED_UNICODE));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $result = curl_exec($ch);
        curl_close($ch);

        $res = json_decode($result, true);

        if($res['name'] == $name) {
            return $res['id'];
        }
        return false;
    }
    function sync_product_folder() {
        $offset = 0;
        $limit = 100;
        $result_size = 0;

        // проверяем прошлую синхронизацию
        //        $result_sync = $mysqli->query("SELECT * FROM `moyskladSync` WHERE `type`='product_folder' AND `result`='ok' ORDER BY `id` DESC LIMIT 0,1;") or die('error at ' . __LINE__ . ' in ' . __FILE__);
        $result_sync = MCsync::where([['type', 'product_folder'], ['result', 'ok']])->orderBy('id', 'desc')->limit(1)->get();

        foreach($result_sync as $row_sync) {
            if($row_sync->size != $row_sync->resultSize) {
                $offset = 0;
            }
            else {
                $offset = $row_sync->offset + $row_sync->size;
            }
        }


        // вытаскиваем существующие рубрики
        $all_rubrics = [];
        $result_rubrics = Category::all();
        foreach ($result_rubrics as $row_rubric) {
            $all_rubrics[$row_rubric['ms_id']] = [
                'id' => $row_rubric['id'],
                'name' => $row_rubric['name'],
                'parent_id' => $row_rubric['parent_id'],
                'ms_id' => $row_rubric['ms_id'],
            ];
        }



        //        Category::query()->update(['cmsDeleted' => 1]);



        $nextUrl = 'https://online.moysklad.ru/api/remap/1.2/entity/productfolder';

        $i = 0;

        $all_product_folders = [];
        $result_size = 0;

        while($nextUrl && $i < 20) {
            $i++;

            $authorization = 'Authorization: Basic ' . base64_encode('it@torg-dom' . ':' . '12345-IT');

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $nextUrl);
            curl_setopt($ch, CURLOPT_CAINFO, base_path('cacert-2023-01-10.pem'));
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json', $authorization]);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            $result = curl_exec($ch);
            curl_close($ch);

            $product_folder_json = json_decode($result, true);

            if(isset($product_folder_json['errors'])) {
                // ошибка
                foreach($product_folder_json['errors'] as $error_data) {
                    $result = $error_data['error'];
                }
                $nextUrl = '';
            }

            //если нет ошибок
            else {

                $nextUrl = isset($product_folder_json['meta']['nextHref']) ? $product_folder_json['meta']['nextHref'] : '';

                $result_size += $product_folder_json['meta']['size'];

                //перебор категорий
                foreach($product_folder_json['rows'] as $product_folder) {

                    //если есть родитель
                    if(isset($product_folder['productFolder'])) {
                        $ms_parent = str_replace('https://online.moysklad.ru/api/remap/1.2/entity/productfolder/', '', $product_folder['productFolder']['meta']['href']);
                    }
                    else {
                        $ms_parent = NULL;
                    }

                    $ms_id = $product_folder['id'];
                    $ms_name = $product_folder['name'];

                    $ms_vis = 1;
                    if($ms_name[0] == '!') {
                        $ms_vis = 0;
                    }

                    $slug = Str::slug($ms_name);

                    $all_product_folders[$ms_id] = [
                        'name' => $ms_name,
                        'slug' => $slug,
                        'parent' => $ms_parent,
                    ];


                    // вставляем новые разделы
                    if(!isset($all_rubrics[$ms_id])) {
                        //                        $mysqli->query("INSERT INTO `catalogRubrics` (`vis`, `msId`, `name`, `uri`, `ordr`) VALUES($ms_vis, '$ms_id', '$ms_name', '$uri', $ordr);") or die('error at ' . __LINE__ . ' in ' . __FILE__);
                        $category = Category::create([
                            'name' => $ms_name,
                            'slug' => $slug,
                            'ms_id' => $ms_id
                        ]);

                        $all_rubrics[$ms_id] = [
                            'id' => $category->id,
                            'name' => $ms_name
                        ];
                    }
                    else {
                        //                        $mysqli->query("UPDATE `catalogRubrics` SET `cmsDeleted`=0, `ordr`=$ordr, `name`='$ms_name', `vis`=$ms_vis WHERE `msId`='$ms_id';") or die('error at ' . __LINE__ . ' in ' . __FILE__);
                        $category = Category::where('ms_id', $ms_id)
                            ->update([
                                'name' => $ms_name,
                                'ms_id' => $ms_id,
                            ]);
                    }
                }


            }

        }

        // апгрейдим названия, порядок и родителей
        foreach($all_product_folders as $ms_id => $ms_data) {

            if($ms_data['parent']) {
                $parent_id = $all_rubrics[$ms_data['parent']]['id'];
            }
            else {
                $parent_id = null;
            }

            //            $mysqli->query("UPDATE `catalogRubrics` SET `name`='$ms_data[name]', `parentId`='$parent_id', `ordr`=$ordr WHERE `msId`='$ms_id';") or die('error at ' . __LINE__ . ' in ' . __FILE__);
            $category = Category::where('ms_id', $ms_id)
                ->update([
                    'name' => $ms_data['name'],
                    'parent_id' => $parent_id
                ]);
        }

        $result = 'ok';

        MCsync::create([
            'type' => 'product_folder',
            'offset' => $offset,
            'size' => $limit,
            'resultSize' => $result_size,
            'result' => $result
        ]);
    }

    public function sync_products()
    {
        $offset = 0;
        $limit = 100;
        $result_size = 0;

        // проверяем прошлую синхронизацию
        //        $result_sync = $mysqli->query("SELECT * FROM `moyskladSync` WHERE `type`='product_folder' AND `result`='ok' ORDER BY `id` DESC LIMIT 0,1;") or die('error at ' . __LINE__ . ' in ' . __FILE__);
        $result_sync = MCsync::where([['type', 'product'], ['result', 'ok']])->orderBy('id', 'desc')->limit(1)->get();

        foreach ($result_sync as $row_sync) {
            if ($row_sync->size != $row_sync->resultSize) {
                $offset = 0;
            } else {
                $offset = $row_sync->offset + $row_sync->size;
            }
        }

        // вытаскиваем существующие рубрики
        $all_rubrics = [];
        $result_rubrics = Category::all();
        foreach ($result_rubrics as $row_rubric) {
            $all_rubrics[$row_rubric['ms_id']] = [
                'id' => $row_rubric['id'],
                'name' => $row_rubric['name'],
                'parent_id' => $row_rubric['parent_id'],
                'ms_id' => $row_rubric['ms_id'],
            ];
        }


        // вытаскиваем существующие продукты
        $all_products = [];
        $result_products = Product::all();
        foreach ($result_products as $row_product) {
            $all_products[$row_product['ms_id']] = $row_product['id'];
        }

        $authorization = 'Authorization: Basic ' . base64_encode('it@torg-dom' . ':' . '12345-IT');

        $url = 'https://online.moysklad.ru/api/remap/1.2/entity/product?offset=' . $offset . '&limit=' . $limit;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CAINFO, base_path('cacert-2023-01-10.pem'));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $authorization));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $result = curl_exec($ch);
        curl_close($ch);

        $product_json = json_decode($result, true);

        if (isset($product_json['errors'])) {

            foreach ($product_json['errors'] as $error_data) {
                $result = $error_data['error'];
            }

        } else {

            foreach ($product_json['rows'] as $product) {

                $ms_id = $product['id'];

                echo($ms_id . '<br>');

                $name = str_replace("'", '&apos;', $product['name']);

                // поставить try и выдавать ошибку
                $slug = Str::slug($name);
                $text = isset($product['description']) ? str_replace("'", '&apos;', $product['description']) : '';
                $article = isset($product['article']) ? $product['article'] : '';

                $weight = $product['weight'];
                $volume = $product['volume'];

                $price = $product['salePrices'][0]['value'] / 100;

                $uom = '';
                if (isset($product['uom']['meta']['href'])) {
                    $uom = self::msGetProductUom($product['uom']['meta']['href']);
                }


                if (isset($product['productFolder'])) {
                    $ms_parent = str_replace('https://online.moysklad.ru/api/remap/1.2/entity/productfolder/', '', $product['productFolder']['meta']['href']);
                    $parent_id = $all_rubrics[$ms_parent]['id'];
                } else {
                    $ms_parent = '';
                    $parent_id = NULL;
                }


                $new_images = array();

                if ($product['images']['meta']['size'] > 0) {
                    $new_images = self::msGetProductImages($product['images']['meta']['href'], $ms_id);
                }


                $main_image = '';
                if (isset($new_images[0])) {
                    $main_image = $new_images[0];
                }



                $existing_images = array();
                if (isset($all_products[$ms_id])) {
                    // UPDATE
                    echo('update<br><br>');
                    $product_id = $all_products[$ms_id];

                    //                    $mysqli->query("UPDATE `catalogItems` SET `rubricId`='$parent_id', `rubricsIds`='$parents_ids', `name`='$name', `uri`='$uri', `article`='$article',
                    //                      `image`='$main_image', `text`='$text', `price`='$price', `unitOfMeasure`='$uom', `weight`='$weight', `volume`='$volume'
                    //                           WHERE `id`='$product_id';") or die('error at ' . __LINE__ . ' in ' . __FILE__);

                    $exist_product = Product::find($product_id)->update([
                        'category_id' => $parent_id,
                        'name' => $name,
                        'slug' => $slug,
                        'article' => $article,
                        'image' => $main_image,
                        'text' => $text,
                        'price' => $price,
                        'unit' => $uom,
                        'weight' => $weight,
                        'volume' => $volume
                    ]);

                    isset($product['attributes']) ? self::setAttributes($product_id, $product['attributes'][0]) : "";

                    // $mysqli->query("UPDATE `catItems` SET `rubricsIds`='$parent_id_2', `name`='$name'  WHERE `id`='$product_id';") or die('error at ' . __LINE__ . ' in ' . __FILE__);

                    //                    $result_images = $mysqli->query("SELECT * FROM `catalogImages` WHERE `catalogItemId`=$product_id;") or die('error at ' . __LINE__ . ' in ' . __FILE__);

                    $result_images = ProductImage::where('product_id', $product_id)->get();

                    foreach ($result_images as $row_image) {
                        $existing_images[] = $row_image['image'];
                    }
                } else {
                    // INSERT
                    echo('insert<br><br>');
                    //                    $mysqli->query("INSERT INTO `catalogItems` (`ordr`, `vis`, `msId`, `rubricId`, `rubricsIds`, `name`, `uri`, `article`,
                    // `image`, `text`, `price`, `unitOfMeasure`, `weight`, `volume`) VALUES($ordr, 1, '$ms_id', '$parent_id', '$parents_ids', '$name',
                    // '$uri', '$article', '$main_image', '$text', '$price', '$uom', '$weight', '$volume');") or die('error at ' . __LINE__ . ' in ' . __FILE__);

                    $new_product = Product::create([
                        'ms_id' => $ms_id,
                        'category_id' => $parent_id,
                        'name' => $name,
                        'slug' => $slug,
                        'article' => $article,
                        'image' => $main_image,
                        'text' => $text,
                        'price' => $price,
                        'unit' => $uom,
                        'weight' => $weight,
                        'volume' => $volume
                    ]);

                    $product_id = $new_product->id;

                    isset($product['attributes']) ? self::setAttributes($product_id, $product['attributes'][0]) : "";

                }


                /*
                // добавляем картинки
                for ($i = 1; $i < count($new_images); $i++) {
                    if (!in_array($new_images[$i], $existing_images)) {
                        //                        $mysqli->query("INSERT INTO `catalogImages` (`ordr`, `catalogItemId`, `image`) VALUES($i, $product_id, '" . $new_images[$i] . "');") or die('error at ' . __LINE__ . ' in ' . __FILE__);
                        ProductImage::create([
                            'product_id' => $product_id,
                            'image' => $new_images[$i]
                        ]);
                    }
                }

                // убираем старые картинки
                $images_remove = array_diff($existing_images, $new_images);
                foreach ($images_remove as $image) {
                    //                    $mysqli->query("DELETE FROM `catalogImages` WHERE `catalogItemId`='$product_id' AND `image`='$image';") or die('error at ' . __LINE__ . ' in ' . __FILE__);
                    $old_images = ProductImage::where([
                        ['product_id' => $product_id],
                        ['image' => $image]
                    ]);
                    if($old_images) {
                        $old_images->delete();
                    }
                }
                */

                $result_size++;

            }
            $result = 'ok';

        }

        MCsync::create([
            'type' => 'product',
            'offset' => $offset,
            'size' => $limit,
            'resultSize' => $result_size,
            'result' => $result
        ]);
    }

    function sync_orders()
    {
//        $result_orders = $mysqli->query("SELECT * FROM `orders` WHERE `ms_id` IS NULL AND `ms_error` IS NULL;") or die('error at ' . __LINE__ . ' in ' . __FILE__);
        $result_orders = Order::whereNull('ms_id')->get();
        foreach($result_orders as $row_order) {

            echo($row_order['id'] . '<br>');

            $order_id = $row_order['id'];

            $ms_order_id = $row_order['ms_id'];

            if(!$ms_order_id) {
                // добавляем контрагента
                $name = $row_order['name'];
                $email = $row_order['email'];
                $phone = self::phoneFormat($row_order['phone']);
                $address = $row_order['address'];

                $customer_id = 0;
//                $result_customer = $mysqli->query("SELECT * FROM `orders_customers` WHERE `phone`='$phone';") or die('error at ' . __LINE__ . ' in ' . __FILE__);
                $result_customer = OrderCustomer::where('phone', $phone)->get();
                foreach($result_customer as $row_customer) {
                    $ms_customer_id = $row_customer['ms_id'];
                    $customer_id = $row_customer['id'];
                }


                if ($result_customer->isEmpty()) {
                    if($ms_customer_id = self::addCustomer($name, $phone, $email, $address)) {
//                        $mysqli->query("INSERT INTO `orders_customers` (`name`, `phone`, `email`, `address`, `ms_id`) VALUES('$name', '$phone', '$email', '$address', '$ms_customer_id');") or die('error at ' . __LINE__ . ' in ' . __FILE__);
                        $customer = OrderCustomer::create([
                            'name' => $name,
                            'phone' => $phone,
                            'email' => $email,
                            'address' => $address,
                            'ms_id' => $ms_customer_id
                        ]);

                        $customer_id = $customer->id;
                    }
                }

                if($customer_id) {
                    // добавляем заказ

                    $ms_data = [
                        'name' => 'С сайта: ' . $row_order['id'],
                        'organization' => [
                            'meta' => [
                                'href' => 'https://online.moysklad.ru/api/remap/1.2/entity/organization/04fb3485-ae9c-11ec-0a80-02210042a095',
                                'type' => 'organization',
                                'mediaType' => 'application/json'
                            ]
                        ],
                        'agent' => [
                            'meta' => [
                                'href' => 'https://online.moysklad.ru/api/remap/1.2/entity/counterparty/' . $ms_customer_id,
                                'type' => 'counterparty',
                                'mediaType' => 'application/json',
                            ]
                        ],
                    ];

                    $authorization = 'Authorization: Basic ' . base64_encode('it@torg-dom' . ':' . '12345-IT');

                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, 'https://online.moysklad.ru/api/remap/1.2/entity/customerorder');

                    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $authorization));
                    curl_setopt($ch, CURLOPT_CAINFO, base_path('cacert-2023-01-10.pem'));
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($ms_data, JSON_UNESCAPED_UNICODE));
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                    $result = curl_exec($ch);
                    curl_close($ch);

                    $res = json_decode($result, true);

                    if(isset($res['id'])) {
                        $ms_order_id = $res['id'];
                        if($ms_order_id) {
                            //                        $mysqli->query("UPDATE `orders` SET `ms_id`='$ms_order_id' WHERE `id`=$order_id;") or die('error at ' . __LINE__ . ' in ' . __FILE__);
                            Order::find($order_id)->update([
                                'ms_id' => $ms_order_id
                            ]);
                        }
                        elseif($res['errors']) {
                            $result = 'Ошибка занесения заказа, возможн он уже добавлен в МС';
                        }
                    }
                    else {
                        $result = $res['errors'][0]['error'];
                    }
                }
                else {
                    $result = 'Не получается добавить клиента';
                }

            }

            if($ms_order_id && !$row_order['ms_products_added']) {
                echo $ms_order_id . '<br>';
                // добавляем товары в заказ (по 100 штук)
//                $order_items = json_decode($row_order['orderData'], true);

                $order_items = Order::find($row_order['id'])->items;
                $offset = 0;
                while($offset < count($order_items)) {
                    $ms_items = [];
                    for($i = 0; $i < 100; $i++) {
                        if(isset($order_items[$offset])) {
                            $item = $order_items[$offset];

//                            $result_item = $mysqli->query("SELECT * FROM `catalogItems` WHERE `id`='$item[id]' LIMIT 0,1;") or die('error at ' . __LINE__ . ' in ' . __FILE__);

                            $result_item = Product::find($item['product_id']);

                            $ms_item = [
                                'quantity' => $item['quantity'] * 1,
                                'price' => $item['price'] * 100,

                                'assortment' => [
                                    'meta' => [
                                        'href' => 'https://online.moysklad.ru/api/remap/1.2/entity/product/' . $result_item['ms_id'],
                                        'metadataHref' => 'https://online.moysklad.ru/api/remap/1.2/entity/product/metadata',
                                        'type' => 'product',
                                        'mediaType' => 'application/json'
                                    ],
                                ],
                            ];

                            $ms_items[] = $ms_item;

                        }
                        $offset += 1;
                    }

                    $authorization = 'Authorization: Basic ' . base64_encode('it@torg-dom' . ':' . '12345-IT');

                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, 'https://online.moysklad.ru/api/remap/1.2/entity/customerorder/' . $ms_order_id . '/positions');

                    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $authorization));
                    curl_setopt($ch, CURLOPT_CAINFO, base_path('cacert-2023-01-10.pem'));
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($ms_items, JSON_UNESCAPED_UNICODE));
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                    $result = curl_exec($ch);
                    curl_close($ch);

                }

//                $mysqli->query("UPDATE `orders` SET `ms_products_added`=1 WHERE `id`=$order_id;") or die('error at ' . __LINE__ . ' in ' . __FILE__);

                Order::find($order_id)->update([
                    'ms_products_added' => 1
                ]);

            }

//            $mysqli->query("UPDATE `orders` SET `ms_error`='$result' WHERE `id`=$order_id;") or die('error at ' . __LINE__ . ' in ' . __FILE__);
            Order::find($order_id)->update([
                'ms_error' => $result,
                'ms_id' => $ms_order_id
            ]);
        }
    }

    function clean_products($days)
    {
        $products = Product::where(
            'updated_at', '<=', Carbon::now()->subDay($days)
        )->delete();
    }

    function sync_counterparty()
    {
        // вытаскиваем существующих заказчиков
        $all_counterparties = [];
        $result_counterparties = OrderCustomer::all();
        foreach ($result_counterparties as $row_counterparty) {
            $all_counterparties[$row_counterparty['ms_id']] = [
                'id' => $row_counterparty['id'],
                'name' => $row_counterparty['name'],
                'ms_id' => $row_counterparty['ms_id'],
                'address' => $row_counterparty['address'],
                'email' => $row_counterparty['email'],
                'phone' => $row_counterparty['phone']
            ];
        }


        $offset = 0;
        $limit = 100;
        $result_size = 0;


        $authorization = 'Authorization: Basic ' . base64_encode('it@torg-dom' . ':' . '12345-IT');

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://online.moysklad.ru/api/remap/1.2/entity/counterparty');
        curl_setopt($ch, CURLOPT_CAINFO, base_path('cacert-2023-01-10.pem'));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json', $authorization]);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $result = curl_exec($ch);
        curl_close($ch);

        $counterparties = json_decode($result, true);

        if(isset($counterparties['errors'])) {
            // ошибка
            foreach($counterparties['errors'] as $error_data) {
                $result = $error_data['error'];
            }
        }

        //если нет ошибок
        else {
            $result_size += $counterparties['meta']['size'];

            //перебор заказчиков
            foreach($counterparties['rows'] as $counterparty) {
                $ms_id = $counterparty['id'];
                $ms_name = $counterparty['name'];
                $address = isset($counterparty['legalAddress']) ? $counterparty['legalAddress'] : '';
                $email = isset($counterparty['email']) ? $counterparty['email'] : '';
                $phone = isset($counterparty['phone']) ? $counterparty['phone'] : '';

                // вставляем новых заказчиков
                if(!isset($all_counterparties[$ms_id])) {

                    $new_counterparty = OrderCustomer::create([
                        'name' => $ms_name,
                        'ms_id' => $ms_id,
                        'address' => $address,
                        'email' => $email,
                        'phone' => $phone
                    ]);

                    $all_counterparties[$ms_id] = [
                        'id' => $new_counterparty->id,
                        'name' => $ms_name,
                        'ms_id' => $ms_id,
                        'address' => $address,
                        'email' => $email,
                        'phone' => $phone
                    ];

                }
                else {
                    OrderCustomer::where('ms_id', $ms_id)
                        ->update([
                            'name' => $ms_name,
                            'ms_id' => $ms_id,
                            'address' => $address,
                            'email' => $email,
                            'phone' => $phone
                        ]);
                }
            }

            $result = 'ok';
        }

        echo $result;

        MCsync::create([
            'type' => 'counterparty',
            'offset' => $offset,
            'size' => $limit,
            'resultSize' => $result_size,
            'result' => $result
        ]);
    }
}
