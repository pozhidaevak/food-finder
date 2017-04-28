/**
 * Created by anton on 19/03/2017.
 */

//actions to execute when DOM is ready and safe to manipulate
$(function () {
    createCustomHandle();
    localStorage.removeItem("loc");
});

var googleAutoComplete;
var restFoods = {};
/*
 This function binds google maps autocomplete class with input element with id 'loc-text'
 Also it prevents form submit event on hitting Enter key
 */
function locAutocomplete() {
    var input = document.getElementById("loc-text");
    googleAutoComplete = new google.maps.places.Autocomplete(input);
    google.maps.event.addDomListener(input, 'keydown', function (e) {
        if (e.keyCode == 13) { //don't submit form on Enter
            e.preventDefault();

        }
    });
}

/**
 * Filter restaurants by location
 */
function locFilter() {
    var targetDist = $('#slider').slider('value');
    var targetLat = googleAutoComplete.getPlace().geometry.location.lat();
    var targetLng = googleAutoComplete.getPlace().geometry.location.lng();
    localStorage["loc"] = targetLat + ',' + targetLng;

    $('div.restaurant').each(function () {
        var currLat = $(this).attr('lat');
        var currLng = $(this).attr('lng');
        var dist = distance(targetLat, targetLng, currLat, currLng, 'M');
        var distStr = dist > 0.1? Math.round(dist * 10) / 10: "<0.1";
        distStr +=" mi";
        $(this).find(".dist-text").text(distStr);
        if ( dist > targetDist) { //TODO handle different units
            $(this).addClass('hidden-by-loc')
        } else {
            $(this).removeClass('hidden-by-loc')
        }
    });
    $('div.distance').show();
    //alert(googleAutoComplete.getPlace().name + googleAutoComplete.getPlace().geometry.location)
}

function createCustomHandle() {
    var handle = $("#custom-handle");
    $("#slider").slider({
        create: function () {
            handle.text($(this).slider("value"));
        },
        slide: function (event, ui) {
            handle.text(ui.value);
        },
        step: 0.1,
        max: 15,
        value: 1
    });
}

function createFoodTree(foods) {
    $('#food_tree')
        .on('changed.jstree', function (e, data) {
            var selLenght = data.selected.length;

            if (selLenght == 0) {
                $('.restaurant').removeClass('hidden-by-food')
            } else {
                var selected_leaves = jQuery.grep(data.selected, function (n) {
                    return data.instance.is_leaf(n)
                })
                $('.restaurant').each(function () {
                    var id = $(this).attr('id');
                    var rest_foods = restFoods[id];
                    if (_.difference(selected_leaves, rest_foods) == 0) {
                        $(this).removeClass('hidden-by-food')
                    } else {
                        $(this).addClass('hidden-by-food')
                    }
                });
            }
        })

        .jstree({
            'core': {
                'data': foods
            },
            'plugins': ['checkbox', 'wholerow', 'search']
        }); //TODO look into state, search and sort plugins here
}

window.onscroll = function() {scrollFunction()};

function scrollFunction() {
    var scrollPos = 20 + document.body.clientHeight;
    if (document.body.scrollTop > scrollPos || document.documentElement.scrollTop > scrollPos) {
        document.getElementById("myBtn").style.display = "block";
    } else {
        document.getElementById("myBtn").style.display = "none";
    }
}

// When the user clicks on the button, scroll to the top of the document
function topFunction() {
    document.body.scrollTop = 0; // For Chrome, Safari and Opera
    document.documentElement.scrollTop = 0; // For IE and Firefox
}