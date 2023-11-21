/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';
import $ from 'jquery';

//this will require bootstrap framework JS
require('bootstrap');


$(document).ready(function () {
    $('.add-another-collection').click(function (e) {
        var list = $("#images-fields-list");
        var counter = list.data('widget-counter') | list.children().length;
        var newWidget = list.attr('data-prototype');
        newWidget = newWidget.replace(/__name__/g, counter);
        counter++;
        list.data('widget-counter', counter);

        var newElem = $(list.attr('data-widget-tags')).html(newWidget);
        newElem.appendTo(list);
        newElem.append('<a href="#" class="remove-tag" style="color: darkred">remove</a>');
        $('.remove-tag').click(function(e) {
            e.preventDefault();

            $(this).parent().remove();

        });
    });
});