
var palette={
    module:{},
};

/*Module de l'application*/
palette.module.app=(function(){
    return{
        start : function(){
            palette.module.liste.init();
        }
    };
})();

palette.module.liste=(function () {
   return{
       init : function () {
           $('th').click(function (event) {
               var color=$(event.currentTarget).parent();
               var td=color.find('td');
               var th=color.find('th');
               if(td.css('display')=='none'){
                   $('td').fadeOut();
                   td.fadeIn();
                   console.log(th.css('width'));
                   td.css('width',th.css('width'));
               }else{
                   $('td').fadeOut();
               }
           });
          $(window).resize(function (event) {
               $('td').css('width',$('th').css('width'));
           })
       }
   };
})();
window.addEventListener('load', function(e) {

    palette.module.app.start();

});