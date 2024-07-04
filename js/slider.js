$(function(){

    //slide 1
    let curSlide = 0;
    let maxSlide = $('.slide-single-first').length - 1;
    let delay = 5000;

    initSlider();
    setInterval(changeSlider, delay);

    function initSlider(){
        $('.slide-single-first').hide(); // Oculta todos os slides
        $('.slide-single-first').eq(0).show(); // Mostra o primeiro slide inicialmente
    }

    function changeSlider(){
        // Oculta o slide atual
        $('.slide-single-first').eq(curSlide).fadeOut(2000, function() {
            // Callback para garantir que a transição seja concluída antes de mostrar o próximo slide
            // Avança para o próximo slide
            curSlide++;
            // Volta ao primeiro slide se estiver no último
            if (curSlide > maxSlide) {
                curSlide = 0;
            }
            // Mostra o próximo slide
            $('.slide-single-first').eq(curSlide).fadeIn(2000);
        });
    }

    //slide 2

    let curSlide2 = 0;
    let maxSlide2 = $('.slide-single-tow').length - 1;
    let delay2 = 5000;

    initSlider2();
    setInterval(changeSlider2, delay2);

    function initSlider2(){
        $('.slide-single-tow').hide(); // Oculta todos os slides
        $('.slide-single-tow').eq(0).show(); // Mostra o primeiro slide inicialmente
    }

    function changeSlider2(){
        // Oculta o slide atual
        $('.slide-single-tow').eq(curSlide2).fadeOut(2000, function() {
            // Callback para garantir que a transição seja concluída antes de mostrar o próximo slide
            // Avança para o próximo slide
            curSlide2++;
            // Volta ao primeiro slide se estiver no último
            if (curSlide2 > maxSlide2) {
                curSlide2 = 0;
            }
            // Mostra o próximo slide
            $('.slide-single-tow').eq(curSlide2).fadeIn(2000);
        });
    }

});