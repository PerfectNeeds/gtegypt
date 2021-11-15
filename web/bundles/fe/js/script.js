$(document).ready(function() {
    var Link = $('#global_reach :selected').val();
    $('#Submit').click(function() {
        //alert($('#global_reach :selected').val());
        window.open($('#global_reach :selected').val(), '_blank');
    });

    small = $('.small ul li').eq(0);
    name = small.children('h2').html();
    more = small.children('a').attr('href');
    position = small.children('.position').html();
    content = small.children('p').children('.content').html();
    telephone = small.children('p').children('.telephone').html();
    email = small.children('p').children('.email').html();
    image = small.children('img').attr('src');

    large = $('.large').children('ul').children('li').eq(0);


    large.children('h2').html(name + ' - ' + position);
    large.children('img').attr('src', image);
    large.children('.more').attr('href', more);
    large.children('.content').html(content);
    large.children('.telephone').html(telephone);
    large.children('.email').html(email);
    large.parent().parent().css({'display': 'block'});

    $('.small ul li').click(function() {
        name = $(this).children('h2').html();
        more = $(this).children('a').attr('href');
        position = $(this).children('.position').html();
        content = $(this).children('p').children('.content').html();
        telephone = $(this).children('p').children('.telephone').html();
        email = $(this).children('p').children('.email').html();
        image = $(this).children('img').attr('src');

        large = $('.large').children('ul').children('li');


        large.children('h2').html(name + ' - ' + position);
        large.children('img').attr('src', image);
        large.children('.more').attr('href', more);
        large.children('.content').html(content);
        large.children('.telephone').html(telephone);
        large.children('.email').html(email);
        large.children('.email').children('.email').children('a').attr('href', email);
        large.parent().parent().css({'display': 'block'});
//        $(this).clone().appendTo($formal);
        ;
    });
    $(".par").click(function(){
    	window.location=$(this).find("a.more").attr("href"); 
        return false;
  	});
});