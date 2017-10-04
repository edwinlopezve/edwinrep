<?php
/**
 * Created by PhpStorm.
 * User: dwin
 * Date: 06/05/17
 * Time: 06:32 PM
 */
?>
<script>
    $(document).ready(function () {
        var locationData = null;
        var poblaciones = localStorage.getItem('poblaciones');
        if (poblaciones == null) {
            $.ajax({
                url: '{!! asset('assets/poblaciones.json') !!}',
                dataType: 'json',
                success: function (data, status) {
                    poblaciones = JSON.stringify(data);
                    localStorage.setItem('poblaciones', JSON.stringify(data));
                    locationData = poblaciones;
                },
                error: function () {
                    console.log('error')
                }
            });
        }
        else
            locationData = JSON.parse(poblaciones);
        $('#search').autoComplete({
            minChars: 3,
            source: function (term, suggest) {
                if (locationData != null) {
                    var suggestions = [];
                    var regex = new RegExp(term, 'gi');
                    for (i = 0; i < locationData.length; i++)
                        if (locationData[i].provincia.match(regex) != null || locationData[i].name.match(regex) != null)
                            suggestions.push(locationData[i]);
                    suggest(suggestions);
                }
            },
            renderItem: function (item, search) {
                search = search.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');
                var re = new RegExp("(" + search.split(' ').join('|') + ")", "gi");
                return '<div class="autocomplete-suggestion" style="height:40px;"' +
                        'data-provincia="' + item.provincia + '" data-name="' + item.name + '">' +
                        '<img src="{!! asset('assets/images/Spain-Flag.png') !!}"> <strong>' + item.provincia.replace(re, "<b>$1</b>") +
                        '</strong> - <em>' + item.name + '</em>' + '</div>';
            },
            onSelect: function (e, term, item) {
                var baseUrl = '{{url( '/' . $controller->getLang() . '/' )}}';
                var provincia = item.attr('data-provincia');
                var name = item.attr('data-name');
                provincia = provincia.split(' ').join('-');
                name = name.split(' ').join('-');
                $('#formulario').get(0).setAttribute('action', baseUrl + '/' + provincia + '/' +name);
                $('#search').val(item.attr('data-provincia') + " - " + item.attr('data-name'))
            }

        });
    });
</script>
