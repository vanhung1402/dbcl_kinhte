$(document).ready(function() {
	$('#container').attr('class', 'container-fluid');

	$('.input-daterange-datepicker').daterangepicker({
        buttonClasses: ['btn', 'btn-sm'],
        applyClass: 'btn-danger',
        cancelClass: 'btn-inverse',
        locale: {
            format: 'DD/MM/YYYY'
        }
    });

	let lopmon_html = ``;
	let onload_html = '<i class="fa fa-spin fa-circle-o-notch"></i> Đang tải dữ liệu...';
	const fa_loading = '<i class="fa fa-spin fa-spinner"></i>';

	function getCsrf(){
		let csrfName = $('.csrf').attr('name');
		let csrfHash = $('.csrf').val();

		return {name: csrfName, hash: csrfHash};
	}


	setTimeout(() => {
		$('.load-dot:eq(0)').trigger('click');
	}, 500);

	$(document).on('click', 'a[name="load-dot"]', function(event) {
		let ma_dotkhaosat 	= $(this).attr('data-id').trim();
		let tr 				= $(this).closest('tr');
		let ma_donvihocvu 	= tr.find('.donvihocvu').html().trim();
		let current_html 	= $(this).html();

		$(this).html(onload_html);
		$('#donvihocvu').html(ma_donvihocvu);
		$('#luumockhaosatchecked').val(ma_dotkhaosat);

		$('#load-dot').block({
            message: `<h4>${fa_loading} Đang tải dữ liệu...</h4>`,
            css: {
                border: '1px solid #fff'
        	}
    	});

		$this = $(this);
    	$.ajax({
    		url: window.location.href,
    		type: 'POST',
    		dataType: 'JSON',
    		data: {
    			action: 'load-lopmon',
    			ma_dotkhaosat: ma_dotkhaosat,
				[getCsrf().name]: getCsrf().hash
    		},
    	})
    	.done(function(res) {
    		if (res.length > 0) {
				$('#load-dot').removeClass('hidden');
    			renderLopMon(res, ma_dotkhaosat);
    		}else{
				$('#load-dot').addClass('hidden');
    			showMessage('warning', 'Kỳ này không có lớp môn');
    		}

    		setTimeout(function(){
				$this.html(current_html);
				$('#load-dot').unblock();
    		}, 250);
    	})
    	.fail(function(err) {
    		console.log(err);
    		console.log("error");
    	})
    	.always(function() {
    	});
	});

	function renderLopMon(dslopmon, ma_dotkhaosat){
		let dslopmon_html = '';
		let phieukhadung = 0;
		let phieudatao = 0;
		let dakhaosat = 0;
		
		dslopmon.forEach( function(lm, index) {
			let danger = (lm.chitiet.sosinhvien !== lm.chitiet.sophieu) ? 'text-danger text-bold' : '';

			let xoaphieu_lopmon = (lm.chitiet.dakhaosat > 0) ? '' :
					`<button value="${lm.ma_lopmon}" name="xoaphieu" class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="top" data-original-title="Loại bỏ phiếu khảo sát cho lớp môn này">
            			<i class="fa fa-ban"></i>
            		</button>`;

            /*<td class="text-center"><label class="label label-${trangthai_lopmon_obj[lm.madm_trangthai_lopmon]}">${lm.tendm_trangthai_lopmon}</label></td>*/

			dslopmon_html += `<tr data-id="${lm.ma_lopmon}" class="lopmon ${danger}">
				<td class="text-center">
					<input tabindex="9" type="checkbox" class="check-lopmon">
                </td>
				<td class="text-center">${index + 1}</td>
				<td class="ten-lopmon">${lm.ten_lopmon}</td>
				<td class="text-center">${lm.nbd}<br>${lm.nkt}</td>
				<td class="text-center nks">${(lm.nbdks) ? `${lm.nbdks}<br>${lm.nktks}` : 'Chưa đặt'}</td>
				<td class="text-center">${lm.ma_hinhthuc}</td>
				<td class="text-center sosinhvien">${lm.chitiet.sosinhvien}</td>
				<td class="text-center sophieu ${danger}">${lm.chitiet.sophieu}</td>
				<td class="text-center">${lm.chitiet.dakhaosat}</td>
				<td class="text-center">
					<button value="${lm.ma_lopmon}" start-date="${lm.nbdks}" end-date="${lm.nktks}" name="suangaykhaosat" class="btn btn-xs btn-success" data-toggle="tooltip" data-placement="top" data-original-title="Thay đổi mốc khảo sát">
            			<i class="fa fa-calendar-o"></i>
            		</button>
					<button value="${lm.ma_lopmon}" name="taophieu" class="btn btn-xs btn-info${ lm.chitiet.sosinhvien ===  lm.chitiet.sophieu ? ' hidden' : ''}"  data-toggle="tooltip" data-placement="top" data-original-title="Cập nhật đủ phiếu khảo sát cho lớp môn">
            			<i class="fa fa-anchor"></i>
            		</button>
					<a href="khaosathoctap/chitiet?lopmon=${lm.ma_lopmon}&dot=${ma_dotkhaosat}" class="btn btn-xs btn-warning" data-toggle="tooltip" data-placement="top" data-original-title="Quản lý phiếu khảo sát" target="_blank">
            			<i class="fa fa-file-text-o"></i>
            		</a>
            		${xoaphieu_lopmon}
				</td>
			</tr>`;

			phieukhadung += Number(lm.chitiet.sosinhvien);
			phieudatao += Number(lm.chitiet.sophieu);
			dakhaosat += Number(lm.chitiet.dakhaosat);
		});

		$('#danhsach-lopmon').html(dslopmon_html);
		$('#timkiem input').focus();
        $('[data-toggle="tooltip"]').tooltip();
        
		$('#phieukhadung').html(phieukhadung);
		$('#phieudatao').html(phieudatao);
		$('#phieudakhaosat').html(dakhaosat);

		$('#load-dot .skin-square input').iCheck({
			checkboxClass: 'icheckbox_square-blue',
			increaseArea: '20%'
		});
	}

	function handingCanBoLopMon(canbo){
		if (!canbo) {
			return '';
		}
		let canbo_obj = [];
		canbo.forEach( cb => {
			// canbo_obj.push(`${cb.hodem_cb}${cb.ten_cb} (${cb.sotietday}T)`);
			canbo_obj.push(`${(cb.hodem_cb).trim()} ${cb.ten_cb}`);
		});

		return canbo_obj.join('<br>');
	}

	const trangthai_lopmon_obj = {
		'daduyet': 'success',
		'huy': 'error',
		'dukien': 'warning',
		'ketthuc': 'info'
	}

	$(document).on('click', 'button[name="suangaykhaosat"]', function(event) {
		let ten_lopmon = $(this).closest('.lopmon').find('.ten-lopmon').html();
		let start_date = $(this).attr('start-date');
		let end_date = $(this).attr('end-date');

		if (start_date != 'null' && end_date != 'null') {
			$('#moclopmon').daterangepicker({
		        buttonClasses: ['btn', 'btn-sm'],
		        applyClass: 'btn-danger',
		        cancelClass: 'btn-inverse',
		        locale: {
		            format: 'DD/MM/YYYY'
		        },
		        startDate: start_date,
		        endDate: end_date,
		    });
		}


		$('#title-lopmon').html(ten_lopmon);
		$('#modal-lopmon').modal('show');

		$('#luumockhaosat').val($(this).val());
	});

	const date_range = 14;
	$(document).on('change', '#mockhaosat', function(event) {
		event.preventDefault();

		let mockhaosat = $(this).val();
		mockhaosat = mockhaosat.split('/');
		mockhaosat = [mockhaosat[1], mockhaosat[0], mockhaosat[2]].join('/');

		let date = new Date(mockhaosat);
		let ngaybatdau = new Date(date.getTime() - (date_range - 1) * 24 * 60 * 60 * 1000);
		let ngayketthuc = new Date(date.getTime() + (date_range - 1) * 24 * 60 * 60 * 1000);
		ngaybatdau = formatDate(ngaybatdau, 'dd/mm/yyyy');
		ngayketthuc = formatDate(ngayketthuc, 'dd/mm/yyyy');

		$('#ngaybatdau').html(ngaybatdau);
		$('#ngayketthuc').html(ngayketthuc);
	});

	const separators = ['-', '/', '.'];
	function formatDate(date, format){
		let separator = '/';
		separators.forEach( sp => {
			if (format.indexOf(sp) !== -1) {
				separator = sp;
			}
		});

		let date_obj = {
			'dd': (date.getDate() < 10) ? `0${date.getDate()}` : date.getDate(),
			'mm': (date.getMonth() + 1 < 10) ? `0${date.getMonth() + 1}` : date.getMonth() + 1,
			'yyyy': date.getFullYear()
		}

		format = format.split(separator);

		let date_with_format = [];
		format.forEach( fm => {
			date_with_format.push(date_obj[fm]);
		});
		return date_with_format.join(separator);
	}

	$(document).on('click', '#luumockhaosat', function(event) {
		let ma_lopmon = $(this).val();
		let mockhaosat = $('#moclopmon').val();

		changeMocKhaoSatLopMom(ma_lopmon, mockhaosat);

		$(this).html(`${fa_loading} Saving...`)
	});

	function changeMocKhaoSatLopMom(ma_lopmon, mockhaosat){
		mockhaosat = mockhaosat.split('-');
		let nbdks = (mockhaosat[0]).trim();
		let nktks = (mockhaosat[1]).trim();

		$.ajax({
			url: window.location.href,
			type: 'POST',
			dataType: 'JSON',
			data: {
				action: 'change-mockhaosat-lopmon',
				lopmon: ma_lopmon,
				nbdks: nbdks.split('/').reverse().join('-'),
				nktks: nktks.split('/').reverse().join('-'),
			},
		})
		.done(function(res) {
			if (res != 0) {

				$(`tr[data-id="${ma_lopmon}"`).find('.nks').html(`${nbdks}<br>${nktks}`);

				$(`tr[data-id="${ma_lopmon}"`).find('button[name="suangaykhaosat"]').attr('start-date', nbdks);
				$(`tr[data-id="${ma_lopmon}"`).find('button[name="suangaykhaosat"]').attr('end-date', nktks);

				$('#modal-lopmon').modal('hide');
				showMessage('success', 'Thay đổi thành công');
			}else{
				showMessage('error', 'Không có thay đổi nào được ghi nhận');
			}
		})
		.fail(function(err) {
			console.log(err);
			showMessage('error', 'Đã có lỗi xảy ra, vui lòng thử lại sau');
		})
		.always(function() {
			$('#luumockhaosat').html('<i class="fa fa-check"></i> Lưu lại');
		});
		
	}

	$(document).on('click', '#config-dotkhaosat', function(event) {
		$('#modal-dotkhaosat').modal('show');
		let today = new Date();
		today = formatDate(today, 'dd/mm/yyyy');

		$('#mockhaosatall').val(today);
	});


	$(document).on('change', '#mockhaosatall', function(event) {
		event.preventDefault();

		let mockhaosat = $(this).val();
		mockhaosat = mockhaosat.split('/');
		mockhaosat = [mockhaosat[1], mockhaosat[0], mockhaosat[2]].join('/');

		let date = new Date(mockhaosat);
		let ngaybatdau = new Date(date.getTime() - (date_range - 1) * 24 * 60 * 60 * 1000);
		let ngayketthuc = new Date(date.getTime() + (date_range - 1) * 24 * 60 * 60 * 1000);
		ngaybatdau = formatDate(ngaybatdau, 'dd/mm/yyyy');
		ngayketthuc = formatDate(ngayketthuc, 'dd/mm/yyyy');

		$('#ngaybatdauall').html(ngaybatdau);
		$('#ngayketthucall').html(ngayketthuc);
	});

	/*$(document).on('click', '#luumockhaosatchecked', function(event) {
		let mockhaosat = $('#mockhaosatall').val();
		let ma_dotkhaosat = $(this).val();
		mockhaosat = mockhaosat.split('/');
		mockhaosat = [mockhaosat[2], mockhaosat[1], mockhaosat[0]].join('-');

		changeMocKhaoSatDot(ma_dotkhaosat, mockhaosat);

		$(this).html(`${fa_loading} Saving...`);
	});*/

	$(document).on('click', '#luumockhaosatchecked', function(event) {
		let mockhaosat = $('#mocdachon').val();
		let list_lopmon = getAllCheckCourse();
		let ma_dotkhaosat = $(this).val();

		if (list_lopmon.length < 1) {
			return;
		}

		changeMocKhaoSatDot(ma_dotkhaosat, mockhaosat, list_lopmon);

		$(this).html(`${fa_loading} Saving...`);
	});

	function getAllCheckCourse(){
		let list_lopmon = [];

		$('#danhsach-lopmon tr').each( (index, lm) => {
			let tr_lm = $(lm);

			if (tr_lm.find('.check-lopmon').parent().hasClass('checked')) {
				list_lopmon.push(tr_lm.attr('data-id'));
			}
		});

		if (list_lopmon.length < 1) {
			showMessage('warning', 'Chưa có lớp môn nào được tích!');
		}

		return list_lopmon;
	}

	function changeMocKhaoSatDot(ma_dotkhaosat, mockhaosat, list_lopmon){
		mockhaosat = mockhaosat.split('-');
		let nbdks = (mockhaosat[0]).trim();
		let nktks = (mockhaosat[1]).trim();
		$('#modal-dotkhaosat').modal('hide');

		$.ajax({
			url: window.location.href,
			type: 'POST',
			dataType: 'JSON',
			data: {
				action: 'change-mockhaosat-all',
				dotkhaosat: ma_dotkhaosat,
				nbdks: nbdks.split('/').reverse().join('-'),
				nktks: nktks.split('/').reverse().join('-'),
				lopmon: JSON.stringify(list_lopmon)
			},
		})
		.done(function(res) {
			if (res != 0) {
				$(`a[data-id="${ma_dotkhaosat}"]`).trigger('click');

				showMessage('success', 'Thay đổi thành công cho tất cả các lớp môn');
			}else{
				showMessage('error', 'Không có thay đổi nào được ghi nhận');
			}
		})
		.fail(function(err) {
			console.log(err);
			showMessage('error', 'Đã có lỗi xảy ra, vui lòng thử lại sau');
		})
		.always(function() {
			$('#luumockhaosatchecked').html('<i class="fa fa-check"></i> Lưu lại');
		});	
	}

	$(document).on('ifChecked ifUnchecked', '#check-all', function(event) {
		let ischecked = event.type.replace('if', '').toLowerCase();
		ischecked = ischecked.substring(0, ischecked.length - 2);
		$('#danhsach-lopmon .check-lopmon').iCheck(ischecked);
	});


	$(document).on('click', 'button[name="taophieu"]', function(event) {
		$this = $(this);
		let this_html = $(this).html();
		let ma_lopmon = $(this).val();
		let ma_dotkhaosat = $('#luumockhaosatchecked').val().trim();

		$(this).html(`${fa_loading} loading...`);

		taoPhieuKhaoSat([ma_lopmon], ma_dotkhaosat);

		$this.html(this_html);
	});


	$(document).on('click', 'button[name="xoaphieu"]', function(event) {
		$this = $(this);
		let this_html = $(this).html();
		let ma_lopmon = $(this).val();
		let ma_dotkhaosat = $('#luumockhaosatchecked').val().trim();

		$(this).html(`${fa_loading} loading...`);

		swal({   
            title: "Xóa tất cả phiếu khảo sát?",   
            text: "Hãy chắc chắn, nếu xóa thì các phiếu khảo sát của lớp môn này không thể khôi phục!",   
            type: "warning",   
            showCancelButton: true,   
            confirmButtonColor: "#DD6B55",   
            confirmButtonText: "Đồng ý, xóa nó!",
            closeOnConfirm: true 
        }, function(result){
        	if (result) {
				xoaPhieuKhaoSat([ma_lopmon], ma_dotkhaosat);
        	}

			$this.html(this_html);
        });

	});

	function taoPhieuKhaoSat(list_lopmon, ma_dotkhaosat) {
		$.ajax({
			url: window.location.href,
			type: 'POST',
			dataType: 'JSON',
			data: {
				action: 'create-survey-form',
				dotkhaosat: ma_dotkhaosat,
				lopmon: JSON.stringify(list_lopmon)
			},
		})
		.done(function(res) {
			if (res != 0) {
				showMessage('success', 'Đã cập nhập đủ phiếu cho lớp môn');
			}else{
				showMessage('error', 'Không có thay đổi nào được ghi nhận');
			}
		})
		.fail(function(err) {
			console.log(err);
			showMessage('error', 'Đã có lỗi xảy ra, vui lòng thử lại sau');
		})
		.always(function() {
			handingLopMon(ma_dotkhaosat);
		});
	}

	function xoaPhieuKhaoSat(list_lopmon, ma_dotkhaosat) {
		$.ajax({
			url: window.location.href,
			type: 'POST',
			dataType: 'JSON',
			data: {
				action: 'remove-survey-form',
				dotkhaosat: ma_dotkhaosat,
				lopmon: JSON.stringify(list_lopmon)
			},
		})
		.done(function(res) {
			if (res != 0) {
				showMessage('success', 'Đã xóa tất cả phiếu của lớp môn');
			}else{
				showMessage('error', 'Không có thay đổi nào được ghi nhận');
			}
		})
		.fail(function(err) {
			console.log(err);
			showMessage('error', 'Đã có lỗi xảy ra, vui lòng thử lại sau');
		})
		.always(function() {
			handingLopMon(ma_dotkhaosat);
		});
	}

	function handingLopMon(ma_dotkhaosat){
		$.ajax({
    		url: window.location.href,
    		type: 'POST',
    		dataType: 'JSON',
    		data: {
    			action: 'load-lopmon',
    			ma_dotkhaosat: ma_dotkhaosat,
				[getCsrf().name]: getCsrf().hash
    		},
    	})
    	.done(function(res) {
    		renderLopMon(res, ma_dotkhaosat);
    	})
    	.fail(function(err) {
    		console.log(err);
    		console.log("error");
    	})
    	.always(function() {
    	});
	}

	$(document).on('click', '#create-all-form', function(event) {
		$this = $(this);
		let this_html = $(this).html();
		let list_lopmon = getAllCheckCourse();
		let ma_dotkhaosat = $('#luumockhaosatchecked').val().trim();

		if (list_lopmon.length < 1) {
			return;
		}

		$(this).html(`${fa_loading} creating...`);

		taoPhieuKhaoSat(list_lopmon, ma_dotkhaosat);

		setTimeout(function(){
			$('#create-all-form').html(this_html);
		}, 500);
	});

	$(document).on('click', '#remove-all-form', function(event) {
		$this = $(this);
		let this_html = $(this).html();
		let list_lopmon = getAllCheckCourse();
		let ma_dotkhaosat = $('#luumockhaosatchecked').val().trim();

		if (list_lopmon.length < 1) {
			return;
		}

		$(this).html(`${fa_loading} removing...`);

		xoaPhieuKhaoSat(list_lopmon, ma_dotkhaosat);

		setTimeout(function(){
			$('#remove-all-form').html(this_html);
		}, 500);
	});

	function locLopMon(){
		let key = $('#timkiem input').val().trim();
		let thoigian = $('#locngay').val();
		let tinhtrangtphieu = $('#locphieu').val();

		if (key === '') {
			$('.lopmon').removeClass('hidden');
		}

		$('.lopmon').each( (index, el) => {
			let ten_lopmon = $(el).find('.ten-lopmon').text().trim().replace('<br>', ' ');
			let tgks_lopmon = $(el).find('.nks').text().trim().replace('<br>', ' ');
			let sosinhvien = $(el).find('.sosinhvien').text().trim();
			let sophieu = $(el).find('.sophieu').text().trim();
			let isShow = true;

			if (ten_lopmon.indexOf(key) === -1) {
				isShow = false;
			}

			if (thoigian !== 'all') {
				if (thoigian === 'dadat' && tgks_lopmon === 'Chưa đặt') {
					isShow = false;
				}
				if (thoigian === 'chuadat' && tgks_lopmon !== 'Chưa đặt') {
					isShow = false;
				}
			}

			if (tinhtrangtphieu !== 'all') {
				if (tinhtrangtphieu === 'chuadu' && sosinhvien === sophieu) {
					isShow = false;
				}
				if (tinhtrangtphieu === 'dadu' && sosinhvien !== sophieu) {
					isShow = false;
				}
			}

			(isShow) ? $('.lopmon').eq(index).removeClass('hidden') : $('.lopmon').eq(index).addClass('hidden');
		});
	}

	$(document).on('keyup', '#timkiem input', function(event) {
		setTimeout(function(){
			locLopMon();
		}, 500);
	});

	$(document).on('change', '#locngay, #locphieu', function(event) {
		locLopMon();
	});

	$(document).on('click', 'button[name="xoadot"]', function(event) {
		return confirm('Có chắc chắn xóa đợt khảo sát này!');
	})

	$(document).on('click', '.btn-change-timerange', function(event) {
		let ma_dotkhaosat = $(this).val();

		let donvihocvu = $(`#hocvu-${ma_dotkhaosat}`).html();
		let tendot = $(`#tendot-${ma_dotkhaosat}`).html();
		let timerange = $(`#timerange-${ma_dotkhaosat}`).html().trim();

		$('#btn-luu-dotkhaosat').val(ma_dotkhaosat);
		$('#time-range-change').val(timerange).change();
		$('#time-range-change').daterangepicker({
	        buttonClasses: ['btn', 'btn-sm'],
	        applyClass: 'btn-danger',
	        cancelClass: 'btn-inverse',
	        locale: {
	            format: 'DD/MM/YYYY',
	        },
	    }).trigger('changeDate');
	});

	$(document).on('change', '#khaosat', function(event) {
		let khaosat = $(this).val();

		window.location.href = `${url}khaosathoctap/dot?khaosat=${khaosat}`;
	});
});