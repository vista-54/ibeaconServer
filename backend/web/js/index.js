/**
 * Created by Виталий on 09.03.2016.
 */

function initBtns() {
    initCount = 0;
    $('button[name=addLoc]').click(function () {
        initCount++;
//                   alert('click');
        var bounds = {
            north: 30.0002,
            south: 29.0002,
            east: 30.0002,
            west: 29.0002
        };

        var infowindow = new google.maps.InfoWindow({});
        rectangle = new google.maps.Rectangle({
            bounds: bounds,
            editable: true,
            draggable: true,
            optimized: false,
            html: 'Click right button mouse for edit location'
        });

        EditOn = false;
        rectangle.addListener('bounds_changed', showNewRect);

        /*Edit Locations*/
        rectangle.addListener('rightclick', function () {
            if (EditOn) {
                return false;
            }
            EditOn = true;
            $('.locationForm').show(); //show loc form
            $('button[name=addLoc]').hide();//hide btn add location
            this.editable = true; //enable edit
            this.editable_changed(function () {
                return true;
            });
            this.draggable_changed(function () {
                return true;
            });
            this.draggable = true; //enable change position

            getLocations(this.id);
        });

        rectangle.addListener('mouseover', function () {
            infowindow.setContent(this.html);
            infowindow.setPosition(this.getBounds().getNorthEast());
            if (!this.editable) {
                infowindow.open(map, this);
            }
            console.log('hover');
        });
        rectangle.addListener('mouseout', function () {
            infowindow.close();
        });
        rectangle.setMap(map);

        $('.locationForm').show();
        $('button[name=addLoc]').hide();
        $('input[name=eventId]').val(window.localStorage.getItem('eventId'));
        if (initCount === 1) {
            $('button[name=saveLoc]').click(function () {

                var data = {
                    id: parseInt($('input[name=locationId]').val()),
                    event_id: parseInt($('input[name=eventId]').val()),
                    name: $('input[name=name]').val(),
                    crd_north: $('input[name=north]').val(),
                    crd_south: $('input[name=south]').val(),
                    crd_east: $('input[name=east]').val(),
                    crd_west: $('input[name=west]').val()
                };
                console.log(data);
                $.post('http://ibeaconserver/backend/places/save-location', data, function (result) {
                    console.log(result);
                    if (result) {
                        EditOn = false;
                        $('.msgLocationSuccess').show();
                        $('.msgLocationError').hide();
                        $('.locationForm').hide();
                        $('button[name=addLoc]').show();
                        rectangle.id = result;//location id in DB
                        rectangle.editable = false;
                        rectangle.editable_changed(function () {
                            return false;
                        });
                        rectangle.draggable_changed(function () {
                            return false;
                        });
                        rectangle.draggable = false;
                        var name = $('input[name=name]').val();
                        window.localStorage.setItem(result, rectangle);
                        //addMarkerLocation($('input[name=lat]').val(),$('input[name=lng]').val());
                        $('.locationsList').append('<a onclick="getLocations(' + result + ')">' + name + '</a><br>');
                        $('input[name=name]').val('');
                        $('input[name=locationId]').val('');
                        $('input[name=north]').val('');
                        $('input[name=south]').val('');
                        $('input[name=east]').val('');
                        $('input[name=west]').val('');

                    }
                    else {
                        $('.msgLocationSuccess').hide();
                        $('.msgLocationError').show();
                    }
                })
            });
        }

        function showNewRect() {
            var ne = rectangle.getBounds().getNorthEast();
            var sw = rectangle.getBounds().getSouthWest();

            var neP = (ne + "").split(',');
            var swP = (sw + "").split(',');
            var north = neP[0].replace('(', '');
            var south = swP[0].replace('(', '');
            var east = neP[1].replace(')', '');
            var west = swP[1].replace(')', '');
            east = east.replace(' ', '');
            west = west.replace(' ', '');

            $('input[name=north]').val(north);
            $('input[name=south]').val(south);
            $('input[name=east]').val(east);
            $('input[name=west]').val(west);
        }
    });
}


function getPlaces(id) {

    var data = {id: id};//id location
    $.post('http://ibeaconserver/backend/place/get-location', data, function (result) {//get location in DB
        console.log(result);
        return result;
    });
    //var obj = JSON.parse(result);
    //$('input[name=locationId]').val(obj.id);
    //$('input[name=eventId]').val(obj.event_id);
    //$('input[name=name]').val(obj.name);
    //$('input[name=north]').val(obj.crd_north);
    //$('input[name=south]').val(obj.crd_south);
    //$('input[name=east]').val(obj.crd_east);
    //$('input[name=west]').val(obj.crd_west);

}


function initMap() {

    //click Add place
    $('button[name=addPlace]').click(function () {
        $('.placeForm').show();
        $('button[name=addPlace]').hide();
        var bounds = {
            north: 15.0002,
            south: 10.0002,
            east: 15.0002,
            west: 10.0002
        };
        var infowindow = new google.maps.InfoWindow({});
        rectangle = new google.maps.Rectangle({
            bounds: bounds,
            editable: true,
            draggable: true,
            optimized: false,
            //html: 'Click right button mouse for edit location'
        });
        rectangle.addListener('bounds_changed', showNewRect);
        rectangle.setMap(map);
        $('input[name="Place[crd_north]"]').val(bounds.north);
        $('input[name="Place[crd_south]"]').val(bounds.south);
        $('input[name="Place[crd_east]"]').val(bounds.east);
        $('input[name="Place[crd_west]"]').val(bounds.west);
        function showNewRect() {
            var ne = rectangle.getBounds().getNorthEast();
            var sw = rectangle.getBounds().getSouthWest();

            var neP = (ne + "").split(',');
            var swP = (sw + "").split(',');
            var north = neP[0].replace('(', '');
            var south = swP[0].replace('(', '');
            var east = neP[1].replace(')', '');
            var west = swP[1].replace(')', '');
            east = east.replace(' ', '');
            west = west.replace(' ', '');

            $('input[name="Place[crd_north]"]').val(north);
            $('input[name="Place[crd_south]"]').val(south);
            $('input[name="Place[crd_east]"]').val(east);
            $('input[name="Place[crd_west]"]').val(west);
        }

        //console.log("fnct");
    });

    //click Add place END
    map = new google.maps.Map(document.getElementById('gmaps'), {
        center: {lat: 0, lng: 0},
        zoom: 4,
        maxZoom: 15,
        minZoom: 0,
        tileSize: new google.maps.Size(256, 256),
        //radius: 155555,
        //optimized:false,
        streetViewControl: false,
        zoomControl: true,
        mapTypeControlOptions: {
            mapTypeIds: ['iBeacons']
        },
        draggableCursor: 'default'

    });

    //function addMarkerLocation(lat, lng) {
    //    var infowindow = new google.maps.InfoWindow({});
    //    var marker = new google.maps.Marker({
    //        position: {lat: parseInt(lat), lng: parseInt(lng)},
    //        map: map,
    //        html: '<button>Add item</button>',
    //        //title: location.name//not nessessary
    //    });
    //    marker.addListener('click', function () {
    //        infowindow.setContent(this.html);
    //        infowindow.open(map, this);
    //    });
    //}

    var f_coords = {count: 0};
    map.addListener('zoom_changed', function () {
        console.log(map.getZoom());
    });
//
//    map.addListener("rightclick", function (event) {
//        var lat = event.latLng.lat();
//        var lng = event.latLng.lng();
//        // populate yor box/field with lat, lng
//
//
//        if (f_coords.count === 1) {
//
//            f_coords.count = 0;
//            console.log(f_coords);
//            var rectangle = new google.maps.Rectangle({
//                strokeColor: 'red',
//                strokeOpacity: 0.8,
//                strokeWeight: 2,
//                fillColor: 'black',
//                fillOpacity: 0.2,
//                map: map,
//                bounds: {
//                    north: f_coords.lat,
//                    south: lat,
//                    east: f_coords.lng,
//                    west: lng
//                }
//            });
//            $('.locationForm').show();
//            $('input[name=eventId]').val(window.localStorage.getItem('eventId'));
//            $('input[name=lat]').val((f_coords.lat + lat) / 2);
//            $('input[name=lng]').val((f_coords.lng + lng) / 2);
//
//        }
//        else {
//            f_coords.count++;
//        }
//
//        f_coords.lat = lat;
//        f_coords.lng = lng;
//        console.log("Lat=" + lat + "; Lng=" + lng);
//
////                createRect();
//    });

    //var maplink = window.localStorage.getItem('mapLink');
    //var eventName = window.localStorage.getItem('eventName');
    //var evId = $('input[name=eventId]').val();
    var locId = $('input[name=locationId]').val();
    var tmrl = 'http://ibeaconserver/backend/web/maps/templates/bg.jpg';

    var iBeacons = new google.maps.ImageMapType({
        /*Get tile url in the backend*/


        getTileUrl: function (coord, zoom) {
            var normalizedCoord = getNormalizedCoord(coord, zoom);
            if (!normalizedCoord) {
                return null;
            }
//                map is bound
            var params = {
                cache: false
            };
            var res = '';
            var obj = {};
            var bound = Math.pow(2, zoom);
            switch (zoom) {
                case 4:
                    if ((normalizedCoord.x === 8) && ((bound - normalizedCoord.y - 1) === 8)) {
                        res = 'http://ibeaconserver/backend/web/maps/' + locId + '/' + zoom + '/' + normalizedCoord.x + '/' + (bound - normalizedCoord.y - 1) + '.jpg';
                    }
                    else {
                        res = tmrl;
                    }
                    ;
                    break;
                case 5:
                    if (((normalizedCoord.x === 16) && ((bound - normalizedCoord.y - 1) === 16)) || ((normalizedCoord.x === 16) && ((bound - normalizedCoord.y - 1) === 17)) || ((normalizedCoord.x === 17) && ((bound - normalizedCoord.y - 1) === 16)) || ((normalizedCoord.x === 17) && ((bound - normalizedCoord.y - 1) === 17))) {
                        res = 'http://ibeaconserver/backend/web/maps/' + locId + '/' + zoom + '/' + normalizedCoord.x + '/' + (bound - normalizedCoord.y - 1) + '.jpg';
                    }
                    else {
                        res = tmrl;
                    }
                    break;
            }


            console.log('http://ibeaconserver/backend/web/maps/' + locId + '/' + zoom + '/' + normalizedCoord.x + '/' + (bound - normalizedCoord.y - 1) + '.jpg');

            return res;

        },
        /*Tile params*/
        tileSize: new google.maps.Size(256, 256),
        radius: 1738000,
        maxZoom: 5,
        minZoom: 4,
        //radius: 155555,
        optimized: false,
        //name: eventName
    });

    map.mapTypes.set('iBeacons', iBeacons);
    map.setMapTypeId('iBeacons');
    var location = $('input[name=locationId]').val();
    //var places = getPlaces(location);
    //console.log(places);
    var infowindow = new google.maps.InfoWindow({});
    var data = {id: location};//id location
    $.post('http://ibeaconserver/backend/place/get-location', data, function (result) {//get location in DB
        console.log(JSON.parse(result));
        var res = JSON.parse(result);
        for (var i in res) {
            var obj = res[i];
            var bounds = {
                north: parseFloat(obj.crd_north),
                south: parseFloat(obj.crd_south),
                east: parseFloat(obj.crd_east),
                west: parseFloat(obj.crd_west)
            };

            rectangle = new google.maps.Rectangle({
                bounds: bounds,
                editable: false,
                draggable: false,
                optimized: false,
                rectId: obj.id,
                html: '<nav><button name="EditLoc" >Edit</button><br><button name="DeleteLoc">Delete</button>',
                name: obj.name,
                /*   editRect:function(){
                 $('.placeForm').show();
                 $('button[name=addPlace]').hide();
                 $('textarea[name="Place[name]"]').val(this.name);
                 $('input[name="Place[crd_north]"]').val(this.bounds.R.j);
                 $('input[name="Place[crd_south]"]').val(this.bounds.R.R);
                 $('input[name="Place[crd_east]"]').val(this.bounds.j.R);
                 $('input[name="Place[crd_west]"]').val(this.bounds.j.j);
                 this.editable = true; //enable edit
                 this.editable_changed(function () {
                 return true;
                 });
                 this.draggable_changed(function () {
                 return true;
                 });
                 this.draggable = true; //enable change position
                 }*/
                //rectId:obj.id
            });


            //rectangle.addListener('mouseover', function () {
            //    if (EditOn) {
            //        return false;
            //    }
            //    infowindow.setContent(this.html);
            //    infowindow.setPosition(this.getBounds().getNorthEast());
            //    if (!this.editable) {
            //        infowindow.open(map, this);
            //    }
            //    console.log('hover');
            //});
            //rectangle.addListener('mouseout', function () {
            //    infowindow.close();
            //});
            var EditOn = false;
            var mode = 'create';
            /*Edit Locations*/
            rectangle.addListener('rightclick', function () {
                var CurrRect = this;
                if (EditOn) {
                    return false;
                }

                infowindow.setContent(this.html);
                infowindow.setPosition(this.getBounds().getNorthEast());
                infowindow.open(map, this);
                $('button[name=EditLoc]').click(function () {
                    //mode = 'update';
                    infowindow.close();
                    EditOn = true;
                    //console.log(this.bounds);
                    //console.log("Edit");
                    //window.location = "http://ibeaconserver/backend/place/update/" + rectangle.rectId;
                    //window.onload = function () {
                    $('.placeForm').show();
                    $('button[name=addPlace]').hide();
                    $('input[name="Place[id]"]').val(CurrRect.rectId);
                    $('textarea[name="Place[name]"]').val(CurrRect.name);
                    $('input[name="Place[crd_north]"]').val(CurrRect.bounds.R.j);
                    $('input[name="Place[crd_south]"]').val(CurrRect.bounds.R.R);
                    $('input[name="Place[crd_east]"]').val(CurrRect.bounds.j.R);
                    $('input[name="Place[crd_west]"]').val(CurrRect.bounds.j.j);

                    CurrRect.editable = true; //enable edit
                    CurrRect.editable_changed(function () {
                        return true;
                    });
                    CurrRect.draggable_changed(function () {
                        return true;
                    });
                    CurrRect.draggable = true; //enable change position
                    //}


                });

                $('button[name=DeleteLoc]').click(function () {
                    //var confirm=  confirm("Are you serious?");
                    //alert(confirm);
                    console.log(CurrRect.rectId);
                    var data = {id: CurrRect.rectId};

                    //data.
                    $.post('http://ibeaconserver/backend/place/delete', data, function (result) {
                        console.log(result);
                        window.location.reload();
                    })
                });


                //
                //$('.placeForm').show();
                //$('button[name=addPlace]').hide();
                //$('textarea[name="Place[name]"]').val(this.name);
                //$('input[name="Place[crd_north]"]').val(this.bounds.R.j);
                //$('input[name="Place[crd_south]"]').val(this.bounds.R.R);
                //$('input[name="Place[crd_east]"]').val(this.bounds.j.R);
                //$('input[name="Place[crd_west]"]').val(this.bounds.j.j);
                //this.editable = true; //enable edit
                //this.editable_changed(function () {
                //    return true;
                //});
                //this.draggable_changed(function () {
                //    return true;
                //});
                //this.draggable = true; //enable change position
                //console.log(this.bounds);

                //getLocations(rectId);
            });
            rectangle.addListener('bounds_changed', showNewRect);
            function showNewRect() {
                var ne = rectangle.getBounds().getNorthEast();
                var sw = rectangle.getBounds().getSouthWest();
                var name = rectangle.name;
                var neP = (ne + "").split(',');
                var swP = (sw + "").split(',');
                var north = neP[0].replace('(', '');
                var south = swP[0].replace('(', '');
                var east = neP[1].replace(')', '');
                var west = swP[1].replace(')', '');
                east = east.replace(' ', '');
                west = west.replace(' ', '');


                $('input[name="Place[crd_north]"]').val(north);
                $('input[name="Place[crd_south]"]').val(south);
                $('input[name="Place[crd_east]"]').val(east);
                $('input[name="Place[crd_west]"]').val(west);
            }

            rectangle.setMap(map);
        }

        //return result;
    });

}

function getNormalizedCoord(coord, zoom) {
    var y = coord.y;
    var x = coord.x;

    // tile range in one direction range is dependent on zoom level
    // 0 = 1 tile, 1 = 2 tiles, 2 = 4 tiles, 3 = 8 tiles, etc
//        var tileRange = 1;
    var tileRange = 1 << zoom;

    // don't repeat across y-axis (vertically)
    if (y < 0 || y >= tileRange) {
        //y = (y % tileRange + tileRange) % tileRange;
        return null;
    }

    //do repeat across x-axis
    if (x < 0 || x >= tileRange) {
        x = (x % tileRange + tileRange) % tileRange;
//            console.log(x);
//        return null;

    }

    console.log({x: x, y: y});
    return {x: x, y: y};
};

$(document).ready(function () {
    $('.inactivity,.activity').click(function (event) {
        var date = event.currentTarget.attributes['data-number'].nodeValue;
        //event.target.childNodes[1].innerText
        openModalWindowOfDate(date);
    })
});

function openModalWindowOfDate(date) {


    var data = {
        date: date
    };

    /* GET Items on Select Date*/
    $.post('http://ibeaconserver/backend/calendar/get-items', data, function (result) {
        console.log(result);

        /*Template Load Modal Window */
        $('.ModalView').load('../../web/templates/tmp.html .ModalWindowCurrentEvent', {cache: false}, function () {
            var res = JSON.parse(result);
            /*Add ITEM CLICK*/
            $('input[name=ItemDate]').val(date);
            $('button[name=addItem]').click(function () {
                $('input[name=ItemTime]').val('');
                //$('input[name=ItemDate]').val('');
                $('input[name=ItemName]').val('');
                $('input[name=location_id]').val('');
                $('input[name=place_name]').val('');
                $('input[name=Itemlink]').val('');
                //$('input[name=ItemDate]').val('');
                $('.addItem').show();
                var data = {
                    locationId: $('input[name=locationId]').val()
                };
                $.post('http://ibeaconserver/backend/place/get-places', data, function (result) {
                    console.log(result);
                    initLocalMap(result);
                });
                $('button[name=saveItem]').click(function () {
                    //console.log('save item clicked');
                    saveItem();
                });
            });
            /*Add ITEM end*/

            $('span[name=date]').html(date);
            $('.ModalView').show();
            for (var i in res) {
                var obj = res[i];
                var time = (obj.date).split(' ');
                $('.ilist').append('<div><span onclick="edit(' + obj.id + ')" class="controllIcons glyphicon glyphicon-pencil"></span><span>' + time[1] + '</span><span class="ItemName"> ' + obj.title + '</span> </div>');
            }

        });

        /*Load MODAL END*/
    })
}

function initLocalMap(result) {
    var res = JSON.parse(result);
    var locArr = res.Places;
    var map = new google.maps.Map(document.getElementById('map'), {
        center: {lat: 0, lng: 0},
        zoom: 5,
        maxZoom: 5,
        minZoom: 4,
        tileSize: new google.maps.Size(256, 256),
        //radius: 155555,
        //optimized:false,
        streetViewControl: false,
        zoomControl: true,
        mapTypeControlOptions: {
            mapTypeIds: ['iBeacons']
        },
        draggableCursor: 'default'

    });
    var tmrl = 'http://ibeaconserver/backend/web/maps/templates/bg.jpg';
    var locId = $('input[name=locationId]').val();
    var iBeacons = new google.maps.ImageMapType({
        /*Get tile url in the backend*/
        getTileUrl: function (coord, zoom) {
            var normalizedCoord = getNormalizedCoord(coord, zoom);
            if (!normalizedCoord) {
                return null;
            }
//                map is bound
            var bound = Math.pow(2, zoom);
            switch (zoom) {
                case 4:
                    if ((normalizedCoord.x === 8) && ((bound - normalizedCoord.y - 1) === 8)) {
                        res = 'http://ibeaconserver/backend/web/maps/' + locId + '/' + zoom + '/' + normalizedCoord.x + '/' + (bound - normalizedCoord.y - 1) + '.jpg';
                    }
                    else {
                        res = tmrl;
                    }
                    ;
                    break;
                case 5:
                    if (((normalizedCoord.x === 16) && ((bound - normalizedCoord.y - 1) === 16)) || ((normalizedCoord.x === 16) && ((bound - normalizedCoord.y - 1) === 17)) || ((normalizedCoord.x === 17) && ((bound - normalizedCoord.y - 1) === 16)) || ((normalizedCoord.x === 17) && ((bound - normalizedCoord.y - 1) === 17))) {
                        res = 'http://ibeaconserver/backend/web/maps/' + locId + '/' + zoom + '/' + normalizedCoord.x + '/' + (bound - normalizedCoord.y - 1) + '.jpg';
                    }
                    else {
                        res = tmrl;
                    }
                    break;
            }


            console.log('http://ibeaconserver/backend/web/maps/' + locId + '/' + zoom + '/' + normalizedCoord.x + '/' + (bound - normalizedCoord.y - 1) + '.jpg');

            return res;
        },
        /*not nessessary*/
        tilesloaded: function (e) {
            console.log(e);
        },
        /*Tile params*/
        tileSize: new google.maps.Size(256, 256),
        zoom: 5,
        maxZoom: 5,
        minZoom: 4,
        //radius: 155555,
        optimized: false,
        //name: eventName
    });
    map.mapTypes.set('iBeacons', iBeacons);
    map.setMapTypeId('iBeacons');

    for (var i in locArr) {
        var obj = locArr[i];
        var bounds = {
            north: parseInt(obj.crd_north),
            south: parseInt(obj.crd_south),
            east: parseInt(obj.crd_east),
            west: parseInt(obj.crd_west)
        };
        var rectangle = new google.maps.Rectangle({
            bounds: bounds,
            editable: false,
            draggable: false,
            optimized: false,
            rectangleId: obj.id,
            rectangleName: obj.name
            //html: 'Click right button mouse for edit location'
        });

        rectangle.addListener('click', function () {
            //rectangle.strokeColor='#FF0000';
            //rectangle.fillColor='#FF0000';
            //console.log("rec Added");
            $('input[name=place_id]').val(this.rectangleId);
            $('input[name=place_name]').val(this.rectangleName);
        });
        rectangle.setMap(map);
    }
}

function closeModal() {
    $('.ModalView').hide();
    window.location.reload();
}

function saveItem() {
    var locationId = $('input[name=locationId]').val();
    var ItemName = $('input[name=ItemName]').val();
    var ItemDate = $('input[name=ItemDate]').val() + ' ' + $('input[name=ItemTime]').val();
    //var time=$('input[name=ItemTime]').val();
    var place_id = parseInt($('input[name=place_id]').val());
    var link = $('input[name=Itemlink]').val();
    var place_name = $('input[name=place_name]').val();
    var itemId = $('input[name=itemId]').val();
    var data = {
        id: itemId,
        title: ItemName,
        date: ItemDate,
        place_id: place_id,
        location_id: locationId,
        link: link,
        place_name: place_name
    }
    console.log(data);
    $.post('http://ibeaconserver/backend/calendar/create', data, function (result) {
        console.log(result);
        if (result === "1") {
            $('span[name=SaveSuccess]').show();
            $('span[name=SaveError]').hide();
        }
        else {
            $('span[name=SaveSuccess]').hide();
            $('span[name=SaveError]').show();
        }
    });
}


function edit(id) {
    var data = {
        id: id
    };
    $('input[name=itemId]').val(id);
    $.post('http://ibeaconserver/backend/calendar/get-info-about-item', data, function (result) {
        console.log(result);
        var resTMP = JSON.parse(result);
        $('.addItem').show();

        var parD = resTMP.date.split(' ');
        $('input[name=ItemTime]').val(parD[1]);
        $('input[name=ItemDate]').val(parD[0]);
        $('input[name=ItemName]').val(resTMP.title);
        $('input[name=place_id]').val(resTMP.place_id);
        $('input[name=place_name]').val(resTMP.place_name);
        $('input[name=Itemlink]').val(resTMP.link);
        $('input[name=location_id]').val(resTMP.location_id);
        /*RESPONSE GET LOCATIONS FOR THIS EVENT*/
        var data = {
            locationId: $('input[name=locationId]').val()
        };
        $.post('http://ibeaconserver/backend/place/get-places', data, function (result) {
            console.log(result);
            initLocalMap(result);
        });
        $('button[name=saveItem]').click(function () {
            //console.log('save item clicked');
            saveItem();
        });
        /*RESPONSE GET LOCATIONS FOR THIS EVENT END*/
    });


}
function editBeaconMap(id) {
    var map = new google.maps.Map(document.getElementById('iBmaps'), {
        center: {lat: 0, lng: 0},
        zoom: 5,
        maxZoom: 5,
        minZoom: 4,
        tileSize: new google.maps.Size(256, 256),
        //radius: 155555,
        //optimized:false,
        streetViewControl: false,
        zoomControl: true,
        mapTypeControlOptions: {
            mapTypeIds: ['iBeacons']
        },
        draggableCursor: 'default'

    });
    map.addListener('mouseover', function (e) {
        console.log(e);
        var marker = new google.maps.Marker({
            position: e.latLng,
            map: map,

        });
        console.log('hover');
    });
    var tmrl = 'http://ibeaconserver/backend/web/maps/templates/bg.jpg';
    var locId = id;
    var iBeacons = new google.maps.ImageMapType({
        /*Get tile url in the backend*/
        getTileUrl: function (coord, zoom) {
            var normalizedCoord = getNormalizedCoord(coord, zoom);
            if (!normalizedCoord) {
                return null;
            }
//                map is bound
            var bound = Math.pow(2, zoom);
            switch (zoom) {
                case 4:
                    if ((normalizedCoord.x === 8) && ((bound - normalizedCoord.y - 1) === 8)) {
                        res = 'http://ibeaconserver/backend/web/maps/' + locId + '/' + zoom + '/' + normalizedCoord.x + '/' + (bound - normalizedCoord.y - 1) + '.jpg';
                    }
                    else {
                        res = tmrl;
                    }
                    ;
                    break;
                case 5:
                    if (((normalizedCoord.x === 16) && ((bound - normalizedCoord.y - 1) === 16)) || ((normalizedCoord.x === 16) && ((bound - normalizedCoord.y - 1) === 17)) || ((normalizedCoord.x === 17) && ((bound - normalizedCoord.y - 1) === 16)) || ((normalizedCoord.x === 17) && ((bound - normalizedCoord.y - 1) === 17))) {
                        res = 'http://ibeaconserver/backend/web/maps/' + locId + '/' + zoom + '/' + normalizedCoord.x + '/' + (bound - normalizedCoord.y - 1) + '.jpg';
                    }
                    else {
                        res = tmrl;
                    }
                    break;
            }


            console.log('http://ibeaconserver/backend/web/maps/' + locId + '/' + zoom + '/' + normalizedCoord.x + '/' + (bound - normalizedCoord.y - 1) + '.jpg');

            return res;
        },
        /*not nessessary*/
        tilesloaded: function (e) {
            console.log(e);
        },
        /*Tile params*/
        tileSize: new google.maps.Size(256, 256),
        zoom: 5,
        maxZoom: 5,
        minZoom: 4,
        //radius: 155555,
        optimized: false,
        //name: eventName
    });
    map.mapTypes.set('iBeacons', iBeacons);
    map.setMapTypeId('iBeacons');
    //console.log(data);

}

function AddMarkerToMap() {
    var ball = document.getElementById('beacon');

    ball.onmousedown = function (e) { // 1. отследить нажатие

        // подготовить к перемещению
        // 2. разместить на том же месте, но в абсолютных координатах
        ball.style.position = 'absolute';
        moveAt(e);
        var map = document.getElementById('mapParent');
        // переместим в body, чтобы мяч был точно не внутри position:relative
        //map.appendChild(ball);
        document.body.appendChild(ball);

        ball.style.zIndex = 1000; // показывать мяч над другими элементами


        // и сдвинуть на половину ширины/высоты для центрирования
        function moveAt(e) {
            ball.style.left = e.pageX - ball.offsetWidth / 2 + 'px';
            ball.style.top = e.pageY - ball.offsetHeight / 2 + 'px';
            console.log(e.layerX);
        }

        // 3, перемещать по экрану
        document.onmousemove = function (e) {
            moveAt(e);
        }

        // 4. отследить окончание переноса
        ball.onmouseup = function () {
            document.onmousemove = null;
            ball.onmouseup = null;
        }
    }
}
function modalLoad(){
    $('.modalButton').click(function () {
        $('#modal').modal('show')
            .find('#modalContent')
            .load($(this).attr('value'));
    })
}