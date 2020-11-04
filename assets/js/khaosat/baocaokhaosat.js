$(document).ready(function() {
    $('.selectpicker').selectpicker();
    $(document).on('change', '#hinhthuc', function(event) {
        let khaosat = $(this).val();

        loadDotKhaoSat(khaosat);
    });

    function loadDotKhaoSat(khaosat, hocvu = null){
        $.ajax({
            url: window.location.href,
            type: 'POST',
            dataType: 'JSON',
            data: {
                action: 'load-dotkhaosat',
                khaosat: khaosat,
            },
        })
        .done(function(res) {
            let dotkhaosat_html = (res.length > 0) ? '' : '<option value="" selected disabled>--- Không có đợt khảo sát ---</option>';

            let arrayDot = {};
            res.forEach( function(dot, index) {
                if (!arrayDot[dot.ma_donvihocvu]) {
                    arrayDot[dot.ma_donvihocvu] = 0;
                }
                arrayDot[dot.ma_donvihocvu]++;

                let namhoc = `${dot.ma_donvihocvu.substring(2, 6)} - ${dot.ma_donvihocvu.substring(7, 11)}`

                dotkhaosat_html += `<option value="${dot.ma_dotkhaosat}">Kỳ ${dot.kyhoc} năm học ${namhoc}</option>`;

            });
            $('#hocvu').html(dotkhaosat_html);
            $('#hocvu').change();
        })
        .fail(function(err) {
            console.log(err);
            console.log("error");
        })
    }
});