$(document).ready(function() {
	let ma_khaosat = 0;
	const fa_loading = '<i class="fa fa-spin fa-spinner"></i>';
	const pattern_topic = `<div class="nhomcauhoi">
		<div class="title-nhomcauhoi">
			<span class="index-topic"></span>. <span class="title-topic"></span>
		</div>
		<div class="child">
			
		</div>
	</div>`;

	const pattern_question = `<div class="question">
		<div class="head-question">
			<span class="index-question"></span>. <span class="title-question"></span>
		</div>
		<div class="list-answer-question row">
		</div>
	</div>`;

	$('#container').removeClass('container');
	$('#container').addClass('container-fluid');

	const phieu_loading = `<div class="alert-loading text-info">
		<i class="fa fa-2x fa-spin fa-spinner"></i> &nbsp; Đang tải phiếu...
	</div>`;

	$(document).on('click', '.phieu', function(event) {
		$('#khaosat-phieu').html(phieu_loading);
		$('.phieu.active').removeClass('active');
		$(this).addClass('active');
		$(this).find('.fa-spin').removeClass('hidden');

		let ma_phieu = $(this).attr('phieu-id');
		$('#luu').attr('phieu-id', ma_phieu);

		$this = $(this);
		loadPhieu(ma_phieu, $this);
	});

	let chitietphieu = [];
	function loadPhieu(ma_phieu, $this){
		$.ajax({
			url: window.location.href,
			type: 'POST',
			dataType: 'JSON',
			data: {
				action: 'load-phieu',
				maphieu: ma_phieu
			},
		})
		.done(function(res) {
			let { cauhoi, chitiet, thongtin } = res;

			renderInfor(thongtin);

			ma_khaosat = cauhoi.ma_khaosat;
			recursion_topic = layTieuDeNhom(cauhoi.nhom);

			$('#khaosat-phieu').empty();

			renderTopic($('#khaosat-phieu'), recursion_topic, 1);

			chitietphieu = chitiet;

			renderListQuestion(cauhoi.chuanhoa);
		})
		.fail(function(err) {
			console.log(err);
			console.log("error");
		})
		.always(function() {
			renderDetail(chitietphieu);

			$this.find('.fa-spin').addClass('hidden');
			$('#khongcodulieu').addClass('hidden');
		});
		
	}

	const separators = ['-', '/', '.'];
	function formatDate(date, format){
		let separator = '/';
		separators.forEach( function(sp) {
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
		format.forEach( function(fm) {
			date_with_format.push(date_obj[fm]);
		});
		return date_with_format.join(separator);
	}

	const date_range = 14;

	function renderInfor(thongtin){
		let today = new Date();
		today = formatDate(today, 'yyyy-mm-dd');

		$('#ngaybatdauks').html(thongtin.nbdks);
		$('#ngayketthucks').html(thongtin.nktks);


		if (!(thongtin.ngaybatdau_khaosat <= today && today <= thongtin.ngayketthuc_khaosat)) {
			$('#luu').attr('phieu-id', null);
			$('#luu').addClass('hidden');		

			$('#thongbao').removeClass('hidden');
			$('#thongbao').html('Đã hết hạn khảo sát!');
		}else{
			$('#luu').removeClass('hidden');
			$('#thongbao').addClass('hidden');
		}

		let giangvien = thongtin.canbo.map(function(cb) {
			// return `${cb.hodem_cb}${cb.ten_cb} - ${cb.sotietday}T`;
			return `${(cb.hodem_cb).trim()} ${cb.ten_cb}`;
		})

		thongtin.giangvien = giangvien.join(' | ');

		for (const [key, value] of Object.entries(thongtin)) {
			$(`#${key}`).html(value);
		}

		$('#thongtinphieu').removeClass('hidden');
	}

	function renderDetail(chitiet){
		chitiet.forEach( function(ct) {
			let question = $(`#question-${ct.ma_cauhoi}`);
			let question_type = question.attr('question-type');

			if (['doan', 'traloingan'].indexOf(question_type) !== -1) {
				question.find('.tunhap').val(ct.noidung_dapan);
			}else{
				if (question_type === 'hopkiem') {
					$(`#dapan-${ct.ma_dapan}`).find('.icheckbox_square-blue').addClass('checked');
				}else{
					$(`#dapan-${ct.ma_dapan}`).find('.iradio_square-blue').addClass('checked');
				}

				if (ct.noidung_dapan !== '') {
					$(`#dapan-${ct.ma_dapan}`).find('.tunhap').val(ct.noidung_dapan);
				}
			}
		});
	}

	function renderListQuestion(dsnhom){
		let isRequired = false;

		for (const [ma_nhom, nhom] of Object.entries(dsnhom)) {
			let chude = $(`#topic-${ma_nhom}`);
			// chude.empty();
			if (nhom.cauhoi !== undefined) {
				nhom.cauhoi.forEach( function(ch, index) {
					let cauhoi = $(`${pattern_question}`);
					cauhoi.attr('id', `question-${ch.ma_cauhoi}`);
					cauhoi.attr('question-id', ch.ma_cauhoi);
					cauhoi.attr('question-type', ch.ma_loaicauhoi);
					cauhoi.attr('is-required', isRequired);
					cauhoi.find('.index-question').first().html(index + 1);
					cauhoi.find('.title-question').first().html(ch.noidung_cauhoi);
					cauhoi.find('.list-answer-question').first().html(renderAnswerOfQuestion(ch.ma_loaicauhoi, ch.da));

					chude.append(cauhoi);
				});
			}

			isRequired = true;
		}

		$('#khaosat-phieu .skin-square input').iCheck({
		    checkboxClass: 'icheckbox_square-blue',
		    radioClass: 'iradio_square-blue',
			increaseArea: '20%'
		});
	}

	const input_question = {
		'traloingan': `<input type="text" class="form-control tunhap" placeholder="Nội dung trả lời..." />`,
		'doan': `<textarea class="form-control tunhap" rows="3" placeholder="Nội dung trả lời ..."></textarea>`,
	}

	function renderAnswerOfQuestion(loai, dapan){
		let dapan_html = '';
		if (['doan', 'traloingan'].indexOf(loai) !== -1) {
			dapan_html = `<div class="form-group answer-question">${input_question[loai]}</div>`;
		}else{
			let type = (loai === 'tracnghiem') ? 'radio' : 'checkbox';
			if (dapan !== undefined || dapan !== null) {
				dapan.forEach( function(da) {
					let name_answer = (loai === 'tracnghiem') ? `dapan-cauhoi-${da.ma_cauhoi}` : `dapan-${da.ma_dapan}`;
					let col = (da.noidung_tunhap === '0') ? '6' : '12';
					let tunhap = (da.noidung_tunhap === '0') ? '' : `<textarea class="form-control tunhap m-t-10" rows="3" placeholder="Ý kiến của bạn..."></textarea>`;

					dapan_html += `<div class="skin skin-square answer-question col-md-${col}" id="dapan-${da.ma_dapan}">
	                            <input name="${name_answer}" id="lable-${da.ma_dapan}" type="${type}">
	                            <label for="lable-${da.ma_dapan}" class="label-answer"> &nbsp; ${da.noidung_dapan}</label>
	                            ${tunhap}
	                        </div>`;
				});
			}
		}

		return $(`${dapan_html}`);
	}

	function renderTopic(root, list_topic, level){
		let sort_topic = list_topic.sort(sortTopic)

		sort_topic.forEach( function(topic) {
			let topic_obj = $(`${pattern_topic}`);
			topic_obj.attr('id', `topic-${topic.id}`);
			topic_obj.attr('topic-id', topic.id);
			topic_obj.attr('level', level);
			topic_obj.find('.index-topic').html(topic.index);
			topic_obj.find('.title-topic').html(topic.title);

			if (topic.child !== undefined) {
				renderTopic(topic_obj.find('.child'), topic.child, (level + 1));
			}

			root.append(topic_obj);
		});
	}

	function layTieuDeNhom(nhom){
		let array_normal = nhom.map( function(topic) {
			return {
				id: topic.ma_nhomcauhoi,
				index: topic.chimuc_nhomcauhoi,
				title: topic.ten_nhomcauhoi,
				parent: topic.ma_nhomcha,
				sort: topic.thutu_nhomcauhoi,
			};
		})

		recursion_topic = normalToRecursion(array_normal);

		return recursion_topic;
	}

	function normalToRecursion(array_normal){
		let map_normal = initMapTopic(array_normal);

		return mapToRecursion(map_normal);
	}

	function initMapTopic(array_topic){
		let map_topic = {};

		array_topic.forEach( function(topic, index) {
			if (!map_topic[`${topic.parent}`]) {
				map_topic[`${topic.parent}`] = [];
			}
			map_topic[topic.parent].push(topic);
		});

		return map_topic;
	}

	function mapToRecursion(map_normal){
		let array_recursion = [];

		array_recursion = map_normal[ma_khaosat].sort(sortTopic);
		delete map_normal[ma_khaosat];

		function handleRecursion(root){
			root.forEach( function(topic, index) {
				if (map_normal[topic.id]) {
					topic.child = handleRecursion(map_normal[topic.id]);
				}

				root[index] = topic;
			});

			return root;
		}

		return handleRecursion(array_recursion);
	}

	function sortTopic(a, b){
		return Number(a.sort) - Number(b.sort);
	}

	$(document).on('click', '#luu', function(event) {
		$this = $(this);
		let ma_phieu = $(this).attr('phieu-id');
		let this_html = $(this).html();
		$(this).html(`${fa_loading} Đang xử lý dữ liệu...`);

		submitQuestion(ma_phieu);

		setTimeout(function(){
			$this.html(this_html);
		}, 250);
	});

	$(document).keydown(function(e) {
		if ((e.which == '115' || e.which == '83' ) && (e.ctrlKey || e.metaKey) && !(e.altKey)){
			$('#luu').trigger('click');
		    return false;
		}
		return true; 
	});

	function submitQuestion(ma_phieu){
		let array_answer_question = [];

		for (var i = 0; i < $('.question').length; i++) {
			let question_obj = $($('.question')[i]);

			let question_value = getAnswerQuestion(question_obj);

			if (question_value === false) {
				return false;
			}else{
				array_answer_question.push(...question_value);
			}
		}


		let chi_tiet_phieu = array_answer_question.map( function(ct) {
			(ct.noidung_dapan === undefined) ? ct.noidung_dapan = '' : 0;
			ct.ma_phieu = ma_phieu;

			return ct;
		})

		$.ajax({
			url: window.location.href,
			type: 'POST',
			dataType: 'JSON',
			data: {
				action: 'submit-phieu',
				maphieu: ma_phieu,
				chitiet: JSON.stringify(chi_tiet_phieu),
			},
		})
		.done(function(res) {
			if (res > 0) {
				showMessage('success', 'Đã lưu kết quả khảo sát.');
				$(`a[phieu-id="${ma_phieu}"`).find('.fa.status').removeClass('hidden');
			}else{
				showMessage('warning', 'Không có thay đổi nào được lưu lại!');
			}
		})
		.fail(function(err) {
			console.log(err);
			showMessage('error', 'Đã có lỗi xảy ra, vui lòng tải lại sau!');
		})
		.always(function() {
			$('#back2Top').click();
		});
	}

	function hasChecked(question_obj){
		let array_answer_obj = question_obj.find('.answer-question');

		for (let i = 0; i < array_answer_obj.length; i++) {
			if (array_answer_obj.eq(i).find('div:first-child').hasClass('checked')) {
				return true;
			}
		}

		return false;
	}

	function getAnswerQuestion(question_obj){
		let question_value = [];
		let id_question = question_obj.attr('question-id');

		if (['tracnghiem', 'hopkiem'].indexOf(question_obj.attr('question-type')) !== -1) {
			if (question_obj.attr('is-required') == 'true' && !hasChecked(question_obj)) {
				showMessage('warning', 'Vui lòng hoàn thành câu hỏi!');

				document.getElementById(
					question_obj.attr('id')
				).scrollIntoView(false);

				return false;
			}

			let array_answer_obj = question_obj.find('.answer-question');
			for (let i = 0; i < array_answer_obj.length; i++) {
				if (array_answer_obj.eq(i).find('div:first-child').hasClass('checked')) {

					question_value.push({
						'ma_cauhoi': id_question,
						'ma_dapan': array_answer_obj.eq(i).attr('id').replace('dapan-', ''),
						'noidung_dapan': array_answer_obj.eq(i).find('.tunhap').val(),
					});
				}
			}
		}else{
			question_value.push({
				'ma_cauhoi': id_question,
				'ma_dapan': 'dapantext',
				'noidung_dapan': question_obj.find('.tunhap').val(),
			});
		}

		return question_value;
	}
});