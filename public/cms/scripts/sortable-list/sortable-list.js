
(function( name, factory ) {

    if( typeof window === "object" ) {

       // add to window
       window[ name ] = factory();
    }

 })


( "Sortable", function() {

    var _w = window,
        _b = document.body,
        _d = document.documentElement;
        _p = document.querySelector('.content__container.container');

    // get position of mouse/touch in relation to viewport
    var getPoint = function( e )
    {
        var scrollX = Math.max( 0, _w.pageXOffset || _d.scrollLeft || _b.scrollLeft || 0 ) - ( _d.clientLeft || 0 ),
           scrollY = Math.max( 0, _w.pageYOffset || _d.scrollTop || _b.scrollTop || 0 ) - ( _d.clientTop || 0 ),
           pointX  = e ? ( Math.max( 0, e.pageX || e.clientX || 0 ) - scrollX ) : 0,
           pointY  = e ? ( Math.max( 0, e.pageY || e.clientY || 0 ) - scrollY ) : 0;

       return { x: pointX, y: pointY };
    };

    // class constructor
    var Factory = function(container, options)
    {
       if( container && container instanceof Element )
       {
          this._container = container;
          this._options   = options || {};
          this._clickItem = null;
          this._dragItem  = null;
          this._hovItem   = null;
          this._sortLists = [];
          this._click     = {};
          this._dragging  = false;

          this._id = Math.floor(Math.random() * Number.MAX_VALUE);

          this._container.setAttribute( "data-is-sortable", this._id );
          this._container.style["position"] = "static";

          window.addEventListener( "mousedown", this._onPress.bind( this ), true );
          window.addEventListener( "touchstart", this._onPress.bind( this ), true );
          window.addEventListener( "mouseup", this._onRelease.bind( this ), true );
          window.addEventListener( "touchend", this._onRelease.bind( this ), true );
          window.addEventListener( "mousemove", this._onMove.bind( this ), true );
          window.addEventListener( "touchmove", this._onMove.bind( this ), true );
       }
    };

    // class prototype
    Factory.prototype = {
       constructor: Factory,

       // serialize order into array list
       toArray: function( attr )
       {
          attr = attr || "id";

          var data = [],
              item = null,
              uniq = "";

          for( var i = 0; i < this._container.children.length; ++i )
          {
             item = this._container.children[ i ],
             uniq = item.getAttribute( attr ) || "";
             uniq = uniq.replace( /[^0-9]+/gi, "" );
             data.push( uniq );
          }
          return data;
       },

       // serialize order array into a string
       toString: function( attr, delimiter )
       {
          delimiter = delimiter || ":";
          return this.toArray( attr ).join( delimiter );
       },

       // checks if mouse x/y is on top of an item
       _isOnTop: function( item, x, y )
       {
          var box = item.getBoundingClientRect(),
              isx = ( x > box.left && x < ( box.left + box.width ) ),
              isy = ( y > box.top && y < ( box.top + box.height ) );
          return ( isx && isy );
       },

       // manipulate the className of an item (for browsers that lack classList support)
       _itemClass: function( item, task, cls )
       {
          var list  = item.className.split( /\s+/ ),
              index = list.indexOf( cls );

          if( task === "add" && index == -1 )
          {
             list.push( cls );
             item.className = list.join( " " );
          }
          else if( task === "remove" && index != -1 )
          {
             list.splice( index, 1 );
             item.className = list.join( " " );
          }
       },

       // swap position of two item in sortable list container
       _swapItems: function( item1, item2 )
       {
          var parent1 = item1.parentNode,
              parent2 = item2.parentNode;

          if( parent1 !== parent2 )
          {
             // move to new list
             parent2.insertBefore( item1, item2 );
          }
          else {
             // sort is same list
             var temp = document.createElement( "div" );
             parent1.insertBefore( temp, item1 );
             parent2.insertBefore( item1, item2 );
             parent1.insertBefore( item2, temp );
             parent1.removeChild( temp );
          }
       },

       // update item position
       _moveItem: function( item, x, y )
       {
          item.style["-webkit-transform"] = "translateX( "+ x +"px ) translateY( "+ y +"px )";
          item.style["-moz-transform"] = "translateX( "+ x +"px ) translateY( "+ y +"px )";
          item.style["-ms-transform"] = "translateX( "+ x +"px ) translateY( "+ y +"px )";
          item.style["transform"] = "translateX( "+ x +"px ) translateY( "+ y +"px )";
       },

       // make a temp fake item for dragging and add to container
       _makeDragItem: function( item )
       {
          this._trashDragItem();
          this._sortLists = document.querySelectorAll( "[data-is-sortable='" + this._id + "']" );

          this._clickItem = item;
          this._itemClass( this._clickItem, "add", "active" );

          this._dragItem = document.createElement( item.tagName );
          this._dragItem.className = "dragging";
          this._dragItem.innerHTML = item.innerHTML;
          this._dragItem.style["position"] = "absolute";
          this._dragItem.style["z-index"] = "999";
          this._dragItem.style["left"] = ( item.offsetLeft || 0 ) + "px";
          this._dragItem.style["top"] = ( item.offsetTop - _p.scrollTop || 0 ) + "px"; // !!!
          this._dragItem.style["width"] = ( item.offsetWidth || 0 ) + "px";

          this._container.appendChild( this._dragItem );
       },

       // remove drag item that was added to container
       _trashDragItem: function()
       {
          if( this._dragItem && this._clickItem )
          {
             this._itemClass( this._clickItem, "remove", "active" );
             this._clickItem = null;

             this._container.removeChild( this._dragItem );
             this._dragItem = null;
          }
       },

       // on item press/drag
       _onPress: function( e )
       {
          if( e && e.target && e.target.parentNode === this._container && e.which == 1)
          {
             e.preventDefault();

             this._dragging = true;
             this._click = getPoint( e );
             this._makeDragItem( e.target );
             this._onMove( e );
          }
       },

       // on item release/drop
       _onRelease: function( e )
       {
          this._dragging = false;
          this._trashDragItem();
          if(this._options.callback) {
              this._options.callback(this.toArray('data-value'));
          }
       },

       // on item drag/move
       _onMove: function( e )
       {
          if( this._dragItem && this._dragging )
          {
             e.preventDefault();

             var point     = getPoint( e );
             var container = this._container;

             // drag fake item
             this._moveItem( this._dragItem, ( point.x - this._click.x ), ( point.y - this._click.y ) );

             // keep an eye for other sortable lists and switch over to it on hover
             for( var a = 0; a < this._sortLists.length; ++a )
             {
                var subContainer = this._sortLists[ a ];

                if( this._isOnTop( subContainer, point.x, point.y ) )
                {
                   container = subContainer;
                }
             }

             // container is empty, move clicked item over to it on hover
             if( this._isOnTop( container, point.x, point.y ) && container.children.length === 0 )
             {
                container.appendChild( this._clickItem );
                return;
             }

             // check if current drag item is over another item and swap places
             for( var b = 0; b < container.children.length; ++b )
             {
                var subItem = container.children[ b ];

                if( subItem === this._clickItem || subItem === this._dragItem )
                {
                   continue;
                }
                if( this._isOnTop( subItem, point.x, point.y ) )
                {
                   this._hovItem = subItem;
                   this._swapItems( this._clickItem, subItem );
                }
             }
          }
       },

    };

    // export
    return Factory;
 });