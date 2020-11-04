$(document).ready(function() {
    $(document).on('change', '#hinhthuc', function(event) {
        let khaosat = $(this).val();

        loadDotKhaoSat(khaosat);
    });

    function loadDotKhaoSat(khaosat){
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
        .fail(function() {
            console.log("error");
        })
        .always(function() {
            console.log("complete");
        });
    }

    $(document).on('click', '.kiemtra-khaosat', function(event) {
        let sv = $(this).attr('masv');
        let dot = $(this).attr('dot');
        let ten = $(this).html();

        $('#student-name').html(ten);
        $('#inketqua').attr({
            masv: sv,
            dot: dot,
        });

        loadKiemTraKhaoSat(sv, dot);
    });

    function loadKiemTraKhaoSat(sv, dot){
        $.ajax({
            url: window.location.href,
            type: 'POST',
            dataType: 'JSON',
            data: {
                action: 'load-kiemtra',
                sv: sv,
                dot: dot,
            },
        })
        .done(function(res) {
            let { dsphieu, ketqua } = res;

            renderListFormResult(dsphieu, parseForm(ketqua));
        })
        .fail(function(err) {
            console.log(err);
            console.log("error");
        })
        .always(function() {
            console.log("complete");
        });
    }

    function parseForm(data){
        let mapForm = {};

        if (data) {
            data.forEach( function(tl, index) {
                if (mapForm[tl.ma_phieu] === undefined) {
                    mapForm[tl.ma_phieu] = [];
                }
                mapForm[tl.ma_phieu].push(tl)
            });
        }

        return mapForm;
    }

    function renderListFormResult(listForm, resultForm){
        $('#resultModal').modal();

        let listForm_html = '';

        if (!(listForm.length > 0)) {
            listForm_html = '<p class="text-danger text-center">Sinh viên này chưa khảo sát</p>';

            $('#inketqua').addClass('hidden');
        }else{
            listForm.forEach( function(f, index) {
                listForm_html += renderFormResult(f, resultForm[f.ma_phieu]);
            });

            $('#inketqua').removeClass('hidden');
        }

        $('#list-form').html($(listForm_html));
    }

    $(document).on('click', '#inketqua', function(event) {
        let sv = $(this).attr('masv');
        let dot = $(this).attr('dot');

        window.open(`${url}khaosathoctap/chitietphieu?masv=${sv}&dot=${dot}`, '_blank');
    });

    function renderFormResult(form, result){
        let result_html = '';

        result.forEach( function(r, index) {
            result_html += `<tr>
                                <td class="text-center">${index + 1}</td>
                                <td>${r.noidung_cauhoi}</td>
                                <td><strong>${(r.noidung_dapan === "Đáp án text") ? r.noidungnhap : r.noidung_dapan}</strong></td>
                            </tr>`;
        });

        let form_html = `<div class="panel panel-default">
                            <div class="panel-heading" data-perform="panel-collapse">${form.ten_monhoc}</div>
                            <div class="panel-wrapper collapse">
                                <div class="panel-body">
                                    <table class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th class="text-center">STT</th>
                                                <th class="text-center">Câu hỏi</th>
                                                <th class="text-center" width="150">Đáp án</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            ${result_html}
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>`;

        return form_html;
    }
});