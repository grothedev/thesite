require(["esri/map",
         "esri/geometry/Extent",
         "esri/SpatialReference",
         "esri/geometry/Point",
         "esri/geometry/Geometry",
         "esri/graphic",
         "esri/symbols/SimpleMarkerSymbol",
         "esri/geometry/mathUtils",
         "esri/Color",
         "esri/geometry/Extent",
         "esri/layers/FeatureLayer",
         "esri/tasks/query",
         "esri/symbols/PictureMarkerSymbol",
         "esri/geometry/Polygon",
         "esri/toolbars/draw",
         "esri/layers/GraphicsLayer",
         "esri/dijit/InfoWindow",
         "esri/InfoTemplate",
         "dojo/dom-construct",
         "dojo/domReady!"], function(Map, Extent, SpatialReference, Point, Geometry, Graphic, SimpleMarkerSymbol, mathUtils, Color, Extent, FeatureLayer, Query, PictureMarkerSymbol, Polygon, Draw, GraphicsLayer, InfoWindow, InfoTemplate, domConstruct) {


            /**
             * --- GLOBAL VARIABLES ---
             */
            const API_URL = "http://grothe.ddns.net:8989/properties";
            //-----------------------------

            //TODO ajax get map markers from API

            var infoWindow = new InfoWindow();

            var map = new Map("map", {
               center: [-96.62, 42.07],
               zoom: 8,
               basemap: "topo",
               infoWindow: infoWindow
            });

            infoWindow.startup();

            //get points from API. testing with wwp rental properties for now
            $.get({
               url: API_URL,
               success: (res)=>{
                  handleResponse(res);
               },
               fail: ()=>{
                  alert("failed");
               },
               crossDomain: true,
               //dataType: "jsonp",
            });

            /**
             * upon user click map, show most significant nodes and activity near
             * if clicked symbol, show info about that node
             */
            map.on("click", (clickEvent)=>{
               var point = new Point(clickEvent.mapPoint);
               if (clickEvent.graphic){
                  var graphic = clickEvent.graphic;
                  //infoWindow.setContent(graphic.getInfoTemplate());
                  infoWindow.show(point, null);
               } else {
                  infoWindow.hide();
               }
            });

         function handleResponse(res){

            //array of Graphic objs to connect the geometries to symbol markers
            var pointGraphics = [];

            var graphicsLayer = new GraphicsLayer({
               //infoTemplate: infoTemplate
            }); //map layer which contains all the points of interest
            console.log(res);

            res.forEach((i)=>{
               var p = new Point(i['lon'], i['lat'], new SpatialReference({wkid:4326}));
               // points.push(p);
               var attrs = i;
               //var g = new Graphic(p, new SimpleMarkerSymbol(), attrs, infoTemplate); //attributes from API
               var infoTemplate = new InfoTemplate({
                  title: "Rental Property",
                  content: genInfoTemplateContent(attrs) // use the first graphic (rental property in this case)
               });
               infoTemplate = new InfoTemplate("Rental Property", "${*}");
               var g = new Graphic(p, new SimpleMarkerSymbol(), attrs, infoTemplate); //"${*}"));
               graphicsLayer.add(g);
            });

            map.addLayer(graphicsLayer);
         }

         /**
          * given a list of attributes of a graphic, return a string representing the html table to appear in the info window
          */
         function genInfoTemplateContent(attrs){
            var res = "<table id=\"map-infowindow\">";
            Object.keys(attrs).forEach((k)=>{
               res += "<tr><th>"+k + "</th><th>" + attrs[k] + "</th></tr>";
            });

            res += "</table>";
            return res;
         }


});
