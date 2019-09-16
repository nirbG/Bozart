/**
 * Created by User on 16/06/2017.
 */
$(function () {
    $('#myTab a:first').tab('show');
    $('#myTab a').click(function (e) {
        e.preventDefault();
        $(this).tab('show');
    })
})
$(document).ready(function() {
    $('.thumbnail').fancybox({
        openEffect  : 'none',
        closeEffect : 'none'
    });

    $('#myCarousel-2').carousel({
        interval: 2500
    });
});
var detailE={
    module:{},
};
/*Module de l'application*/
detailE.module.app=(function(){
    return{
        start : function(){
            detailE.module.switch.init();
        }
    };
})();
detailE.module.switch=(function(){
    return{
        init : function(){
            var l=$(".mySelect");
            var a=0;
            var select;
            while(a<l.length){
                if(a==0){
                    select=$(l[a]);
                    var opt=select.children();
                    $(opt[0]).prop('selected', true);
                    $(".price").html("<Strong>Prix : "+ $(opt[0]).attr("prix")+" €</strong>");
                    select.show();
                }else{
                    select=$(l[a]);
                    select.hide();
                }
                a++;
            }
            $('.myOption').click(function(e){
                $(".mySelect").hide();
                var b=$(e.currentTarget).val();
                select=$('#'+b);
                console.log(select);
                var opt=select.children();
                $(opt[0]).prop('selected', true);
                $(".price").html("<Strong>Prix : "+ $(opt[0]).attr("prix")+" €</strong>");
                select.show();
            });
            $(".mySelect").change(function(e){
                var o=$(e.target).children();
                a=0;
                while(a<o.length) {
                    if ($(this).val() == $(o[a]).attr("value")) {
                        $(".price").html("<Strong>Prix : "+ $(opt[a]).attr("prix")+" €</strong>");
                    }
                    a++;
                }
            });
            $('#CalculerPrix').click(function(e) {
                var input=$(".mySelect").children('input');
                var prixM=$(".mySelect").find('span');
                var longueur=parseFloat($(input[0]).val());
                var largeur=parseFloat($(input[1]).val());
                var prixM=parseFloat($(prixM[0]).text());
                var res=((longueur+largeur)*1.20*prixM)/100;
                $(".price").html("<Strong>Prix : "+res+" €</strong>");
            });
        }
    }
})();
window.addEventListener('load', function(e) {
    detailE.module.app.start();
});
