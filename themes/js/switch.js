/**
 * Created by nathalie on 18/04/2017.
 */
var bozart={
    module:{},
};

/*Module de l'application*/
bozart.module.app=(function(){
    return{
        start : function(){
            bozart.module.switch.init();
            bozart.module.switchP.init();
        }
    };
})();

bozart.module.switch=(function(){
    return{
        init : function(){
            var opt=$(".mySelect ").children();
            $(opt[0]).prop('selected', true);

            $(".mySelect").change(function(e){
                var o=$(e.target).children();
                a=0;
                while(a<o.length) {
                    if ($(this).val() == $(o[a]).attr("value")) {
                        $(".price").html("<Strong>Price : "+$(o[a]).attr("prix")+"</strong>");
                    }
                    a++;
                }
            });
        }
    }
})();

bozart.module.switchP=(function(){
    return{
        init : function(){
            var ligne=$("tr");
            while(ligne.length>0){
                var opt=$(ligne.find(".mySelectP")).children();
                $(opt[0]).prop('selected', true);
                var price=$(ligne).find(".price");
                price.html("<Strong>Prix : "+$(opt[0]).attr("prix")+"</strong>");
                ligne=ligne.next();
            }
            $(".mySelectP option").click(function(event){
                var tr=$(event.target).closest('tr');
                var price=$(tr).find(".price");
                price.html("<Strong>Prix : "+$(event.target).attr("prix")+"</strong>");
            });
        }
    }
})();

window.addEventListener('load', function(e) {

    bozart.module.app.start();

});