$(document).ready(() => {
    $(".remove").on("click", e => {
        showMessage("error", "Giá trị này đang được cán bộ sử dụng");
    });

    $("#them").on("click", e => {
        if($("#donvi").val() === null || $("#hocham").val() === null){
            e.preventDefault();
            showMessage("error","Thông tin cán bộ chưa đầy đủ");
        }
    });
});