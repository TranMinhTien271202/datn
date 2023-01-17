window.updateShortList = function updateShortList() {
    $(".btn-shortlisted").on('click',function(e){
        var thisElemt = $(this)
        var id = $(this).data('id');
        var shortlistId = $(this).attr('data-shortlistId');
        if (shortlistId=="") {
            addShortList(thisElemt,id);
        }else{
            removeShortList(thisElemt,shortlistId)
        }
    })
    function addShortList(thisElemt,idJOb){
        var data = {
                "id" : idJOb
                }
        $.ajax({
            type: "GET",
            url: window.location.origin+`/shortlisted/`+idJOb,
            data: data,
            success: function(response) {
                thisElemt.children().css("color","#f7941d")
                thisElemt.attr('data-shortlistId',response.shortlistedId)
                toastr.success("Cập nhật thành công")
            },
        });
    }
    function removeShortList(thisElemt,shortlistId){
        var data = {
                "id" : shortlistId
                }
        $.ajax({
            type: "GET",
            url: window.location.origin+`/delete-shortlisted/`+shortlistId,
            data: data,
            success: function(response) {
                thisElemt.children().css("color","black")
                thisElemt.attr('data-shortlistId',"")
                toastr.success("Cập nhật thành công")
            },
        });
    }
}