$(document).ready(function(){

  $("#buttonGrow").click(function(){
    //$("#corps-game .corps-game-img").animate({ fontSize:"20px"}, 1000);
    $("#corps-game .corps-game-img").animate({ width: '0px'}, 1000);
    $("#corps-game #corps-game-block-left").animate({ width: '30px'}, 1000);
    $("#corps-game #corps-game-block-right").animate({ width: '1400px'}, 1000);
    $("#block-left-block-title").hide();
    $("#block-left-block-title .liste-consoles").hide();
    $("#block-left-block-title .note-block-title").hide();

    $("#test-selected").animate({ width: '1250px', marginLeft: '55px'}, 1000);
    $("#test-selected-left").animate({ width: '750px'}, 1000);
    $("#test-selected #content-test-selected").animate({ width: '710px'}, 1000);
    $("#test-selected-right").animate({ width: '450px'}, 1000);

    $("#onglets li").animate({ marginLeft: '20px', fontSize: '28px'}, 150);
    $("#onglets img").animate({ height: '30px'}, 1000);
    $("#onglets .border-menu").animate({marginLeft: '30px'}, 1000);
    $("#game-description").animate({marginLeft: '25px', width: '950px'}, 1000);
    $("#game-content-test").animate({ diplay: 'inline-block', marginLeft: '2%', marginTop: '20px'}, 1000);

    $("#lol").hide();
    $("#lol1").show();
    $("#unhide").hide();
    $("#test").hide();
    $("#hide").hide();
    $("#addCommentContainer").show();
    $("#body").animate({ width:'250px', height: '320px'}, 1000);
    $("#name").animate({ width:'250px',}, 1000);
    $("#submit").animate({width:'252px', marginBottom:'70px'}, 1000);
    $("#commentContent").animate({width:'820px', height:'495px'}, 1000);
    /*$(".comment").animate({width:'775px', height:'150px'}, 1000);
    $(".name").animate({width:'685px'}, 1000);
    $(".comment p").animate({width:'685px',height:'112px'}, 1000);*/

    $("#buttonGrow").hide();
    $("#buttonShrink").show();
    $("#h1").show();
    /*$("#slider1_container").hide();
    $("#slider2_container").show();*/
    $("#game-content").animate({width:'100%'},0);

    $(".wallop-slider--vertical-slide .wallop-slider__list").animate({width:'1500px',height:'650px'},1000);
    $(".wallop-slider__item img").animate({height:'700px'},1000);
    $(".btn--next").animate({right:'-785px'},1000);
  });





    $("#buttonShrink").click(function(){
      //$("#corps-game .corps-game-img").animate({ fontSize:"20px"}, 1000);
      $("#corps-game .corps-game-img").animate({ width: '465px'}, 1000);
      $("#corps-game #corps-game-block-left").animate({ width: '465px'}, 1000);
      $("#corps-game #corps-game-block-right").animate({ width: '1000px'}, 1000);
      $("#block-left-block-title").show();
      $("#block-left-block-title .liste-consoles").show();
      $("#block-left-block-title .note-block-title").show();

      $("#test-selected").animate({ width: '920px', marginLeft: '15px'}, 1000);
      $("#test-selected-left").animate({ width: '550px'}, 1000);
      $("#test-selected #content-test-selected").animate({ width: '510px'}, 1000);
      $("#test-selected-right").animate({ width: '320px'}, 1000);

      $("#onglets li").animate({marginLeft: '0px', fontSize: '20px'}, 50);
      $("#onglets img").animate({ height: '22px'}, 1000);
      $("#onglets .border-menu").animate({marginLeft: '20px'}, 1000);
      $("#game-description").animate({ marginLeft: '0px',width: '600px'}, 1000);
      $("#game-content-test").animate({ diplay: 'inline-block', marginLeft: '2%', marginTop: '20px'}, 1000);

      $("#lol").show();
      $("#lol1").hide();
      $("#unhide").show();
      $("#test").show();
      $("#hide").show();
      $("#addCommentContainer").hide();
      $("#body").animate({ width:'200px', height: '285px'}, 1000);
      $("#name").animate({ width:'200px',}, 1000);
      $("#submit").animate({width:'202px', marginBottom:'105px'}, 1000);
      $("#commentContent").animate({width:'720px', height:'450px'}, 1000);
      /*$(".comment").animate({width:'775px', height:'150px'}, 1000);
      $(".name").animate({width:'685px'}, 1000);
      $(".comment p").animate({width:'685px',height:'112px'}, 1000);*/

      $("#buttonShrink").hide();
      $("#buttonGrow").show();
      $("#buttonGrow").animate({marginLeft:'430px'}, 1000);
      $("#h1").hide();
      /*$("#slider1_container").show();
      $("#slider2_container").hide();*/

      $(".wallop-slider--vertical-slide .wallop-slider__list").animate({width:'900px'},1000);
      $(".btn--next").animate({right:'-340px'},1000);
    });



  /*$("#llll").click(function(){
    $("#gg").animate({ fontSize:"10px"}, 1000);
    $("#div1").animate({ width: '30%', height:'100px'}, 1000);
    $("#div2").animate({ width: '69%', height:'100px'}, 1000);
    $("#ll").show();
    $("#llll").hide();
  });*/


});
