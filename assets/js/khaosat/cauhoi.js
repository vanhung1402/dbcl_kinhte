$(document).ready(function() {
	$("ul.topic-content").sortable();
	$("ul.topic-content").disableSelection();
	const default_noidung_cauhoi = 'Câu hỏi';
	const cauhoi_mau = `<li class="cauhoi m-b-15 ui-state-default">
		<div class="row noidung-container">
			<div class="col-md-8">
				<div class="form-group">
					<input type="text" class="noidung-cauhoi-input form-control" value="${default_noidung_cauhoi}">
				</div>
				<span class="noidung-cauhoi-label">${default_noidung_cauhoi}</span>
			</div>
			<div class="col-md-3">
				<div class="form-group">
					<select name="loaicauhoi" class="form-control loaicauhoi">
						<option value="traloingan">Trả lời ngắn</option>
						<option value="doan">Đoạn</option>
						<option value="tracnghiem" selected>Trắc nghiệm</option>
						<option value="hopkiem">Hộp kiểm</option>
					</select>
				</div>
			</div>
			<div class="col-md-1">
				<div class="toggle-giatri-cauhoi">
					<input type="checkbox" class="giatri-cauhoi" data-toggle="toggle" data-size="mini" data-on="C" data-off="K" data-onstyle="warning">
				</div>
			</div>
		</div>
		<div class="row dapan-container m-t-5">
			<div class="col-md-12 danhsach-dapan">
			</div>
			<div class="col-md-12 add-dapan">
				<p><span class="them">Thêm tùy chọn</span> hoặc<button class="themkhac">thêm "Khác"</button></p>
			</div>
		</div>

		<div class="tacvu-cauhoi">
			<button class="copy-cauhoi">
				<i class="mdi mdi-content-copy"></i>
			</button>
			<button class="xoa-cauhoi">
				<i class="mdi mdi-delete"></i>
			</button>
		</div>
	</li>`;

	let map_dapan = {
		'traloingan': `<input type="text" class="form-control traloingan" placeholder="Nội dung câu trả lời ngắn..." />`,
		'doan': `<textarea class="form-control tunhap" rows="3" placeholder="Nội dung câu trả lời dài..."></textarea>`,
		'tracnghiem': [{noidung: 'Đáp án 1', giatri: false, thutu: 0, tunhap: false}],
		'hopkiem': [{noidung: 'Đáp án 1', giatri: true, thutu: 0, tunhap: false}],
	}

	const dapan_check_html = `<div class="dapan">
							<div class="noidung-dapan">
								<div class="checkbox checkbox-info">
                                    <input type="checkbox" disabled checked>
                                    <label class="noidung-dapan-label">&nbsp;</label>
                                    <form class="form-material form-horizontal">
                                    	<input class="noidung-dapan-input form-control" type="text">
                                    </form>
                                </div>
							</div>
							<div class="tacvu-dapan m-t-10 m-b-10">
								<input type="checkbox" class="giatri-dapan" data-toggle="toggle" data-size="mini" data-on="Đ" data-off="S" data-onstyle="info">
								<button type="button" class="btn-xoadapan">
									<i class="fa fa-times"></i>
								</button>
							</div>
						</div>`;

	const pattern_topic = 
	`<div class="topic">
		<div class="main">
			<p><span class="index-topic"></span><span class="title-topic"></span></p>
		</div>
		<div class="child">
		</div>
	</div>`;

	let id_cauhoi_focus = null;
	let isClickRemove = false;
	let recursion_topic = [];

	loadTopic();

	function getCsrf(){
		let csrfName = $('.csrf').attr('name');
		let csrfHash = $('.csrf').val();

		return {name: csrfName, hash: csrfHash};
	}

	function loadTopic(){
		$.ajax({
			url: window.location.href,
			type: 'POST',
			dataType: 'JSON',
			data: {
				action: 'load-topic',
				[getCsrf().name]: getCsrf().hash
			},
		})
		.done(function(res) {
			let array_normal = res.map( topic => {
				return {
					id: topic.ma_nhomcauhoi,
					index: topic.chimuc_nhomcauhoi,
					title: topic.ten_nhomcauhoi,
					parent: topic.ma_nhomcha,
					sort: topic.thutu_nhomcauhoi
				};
			})

			recursion_topic = normalToRecursion(array_normal);
		})
		.fail(function(err) {
			console.log(err);
			showMessage('error', 'Đã có lỗi xảy ra, vui lòng tải lại sau!');
		})
		.always(function() {
			renderTopic($('#list-topic'), recursion_topic);
		});
	}

	function renderTopic(root, list_topic){
		let sort_topic = list_topic.sort(sortTopic)

		sort_topic.forEach( function(topic) {
			let topic_obj = $(`${pattern_topic}`);
			topic_obj.attr('id', topic.id);
			topic_obj.find('.index-topic').html(topic.index + '.');
			topic_obj.find('.title-topic').html(topic.title);

			if (topic.child !== undefined) {
				renderTopic(topic_obj.find('.child'), topic.child);
			}

			root.append(topic_obj);
		});
	}

	function sortTopic(a, b){
		return Number(a.sort) - Number(b.sort);
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
		let array_recursion = []

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

	function onFocusCauHoi(cauhoi){
		let id_cauhoi = cauhoi.attr('id');
		if (!cauhoi.hasClass('focus-cauhoi')) {
			cauhoi.addClass('focus-cauhoi');
			if (id_cauhoi != id_cauhoi_focus) {
				cauhoi.find('.noidung-cauhoi-input').focus();
				id_cauhoi_focus = cauhoi.attr('id');
			}
		}
	}


	let map_dapan_tong = {};

	function initNewQuestion(){
		let cauhoi_vuathem = $('ul.topic-content .cauhoi').last();
		let id_cauhoi_vuathem = `${Date.now()}`;

		cauhoi_vuathem.attr('id', id_cauhoi_vuathem);
		cauhoi_vuathem.find('.loaicauhoi').val('tracnghiem');
		cauhoi_vuathem.find('.giatri-cauhoi').bootstrapToggle('off');


		let loaicauhoi = cauhoi_vuathem.find('.loaicauhoi').val();

		map_dapan_tong[`${id_cauhoi_vuathem}`] = [{id: `${Date.now()}`, noidung: 'Đáp án 1', giatri: true, thutu: 0, tunhap: false}];

		renderAnswerOfQuestion(cauhoi_vuathem, {'loaicauhoi': loaicauhoi, 'dapan': map_dapan_tong[`${id_cauhoi_vuathem}`]});

		onFocusCauHoi(cauhoi_vuathem);
	}

	function renderAnswerOfQuestion(cauhoi, array_dapan){
		let id_cauhoi = cauhoi.attr('id');
		let dapan_html = '';

		switch (array_dapan.loaicauhoi) {
			case 'traloingan':
			case 'doan':{
				dapan_html = `<div class="row"><div class="col-md-12 form-group dapan">${array_dapan.dapan}</div></div>`;

				if (!cauhoi.find('.add-dapan').hasClass('hidden')) {
					cauhoi.find('.add-dapan').addClass('hidden');
				}

				delete map_dapan_tong[id_cauhoi];
				cauhoi.find('.danhsach-dapan').html(dapan_html);
				cauhoi.find('.toggle-giatri-cauhoi').addClass('hidden');

				break;
			}

			case 'tracnghiem':
			case 'hopkiem':{
				renderCheckAnswer(cauhoi, array_dapan);
				cauhoi.find('.toggle-giatri-cauhoi').removeClass('hidden');
				break;
			}

			default:
				break;

		}
	}

	const thutu_dapan_themkhac = 1000;
	function renderCheckAnswer(cauhoi, array_dapan){
		let id_cauhoi = cauhoi.attr('id');
		let hasOtherAnswer = false;
		let ds_dapan = array_dapan.dapan.sort((a, b) => {
			return a.thutu - b.thutu;
		})

		cauhoi.find('.danhsach-dapan').html('');

		ds_dapan.forEach( function(da, index) {
			let dapan_html = $(`${dapan_check_html}`);
			let id_dapan = `${da.id}`;

			dapan_html.attr({
				'id': id_dapan,
			});

			if (array_dapan.loaicauhoi === 'tracnghiem') {
				dapan_html.find('.checkbox').addClass('checkbox-circle');
				dapan_html.find('input').attr({
					'name': `dapan-cauhoi-${id_cauhoi}`,
				});
			}

			dapan_html.find('input').attr({
				'id-dapan': `${id_dapan}-input`,
			});

			dapan_html.find('.noidung-dapan-input').attr('id', `${id_dapan}-noidung`);
			dapan_html.find('.noidung-dapan-input').val(`${da.noidung}`);
			dapan_html.find('.noidung-dapan-input').attr({
				'id-dapan': id_dapan,
			});

			dapan_html.find('.noidung-dapan-label').attr({
				'for': `${id_dapan}-noidung`,
			});

			dapan_html.find('.btn-xoadapan').attr({
				'id-dapan': id_dapan,
			});

			if (array_dapan.dapan.length < 2) {
				dapan_html.find('.btn-xoadapan').html('');
			}

			dapan_html.find('.giatri-dapan').bootstrapToggle(da.giatri ? 'on' : 'off');
			dapan_html.find('.giatri-dapan').attr('id-dapan', id_dapan);

			cauhoi.find('.danhsach-dapan').append(dapan_html);

			if (da.tunhap) {
				dapan_html.find('.noidung-dapan').append('<textarea class="form-control tunhap" rows="2" placeholder="Ý kiến của bạn..."></textarea>');
				hasOtherAnswer = true;
			}
		});

		cauhoi.find('.add-dapan').attr('id-cauhoi', id_cauhoi);

		if (cauhoi.find('.add-dapan').hasClass('hidden')) {
			cauhoi.find('.add-dapan').removeClass('hidden');
		}

		if (hasOtherAnswer) {
			cauhoi.find('.themkhac').attr({
				'disabled': true,
				'title': 'Đã tồn tại ý kiến khác'
			});
		}else {
			cauhoi.find('.themkhac').removeAttr('disabled');
			cauhoi.find('.themkhac').removeAttr('title');
		}

		isClickRemove = true;
	}

	$(document).on('click', '.cauhoi', function(event) {
		onFocusCauHoi($(this));
	});

	$(document).on('change', '.noidung-cauhoi-input', function(event) {
		let noidung_cauhoi = $(this).val();

		$(this).closest('.cauhoi').find('.noidung-cauhoi-label').html(noidung_cauhoi);
	});

	$(document).on('click', '#add-cauhoi', function(event) {
		$('ul.topic-content .empty-topic').remove();
		$('ul.topic-content').append(cauhoi_mau);
		$('.cauhoi').removeClass('focus-cauhoi');
		initNewQuestion();
	});

	$(document).on('click', '.add-dapan .them', function(event) {
		let cauhoi = $(this).closest('.cauhoi');
		let loaicauhoi = cauhoi.find('.loaicauhoi').val();
		let id_cauhoi = cauhoi.attr('id');

		let max_thutu = 1;
		map_dapan_tong[id_cauhoi].forEach( da => {
			max_thutu = (max_thutu < da.thutu && da.thutu !== thutu_dapan_themkhac) ? da.thutu : max_thutu;
		});

		map_dapan_tong[id_cauhoi].push({id: `${Date.now()}`, noidung: `Đáp án ${max_thutu + 1}`, giatri: false, thutu: max_thutu + 1, tunhap: false});
		renderCheckAnswer(cauhoi, {'loaicauhoi': loaicauhoi, 'dapan': map_dapan_tong[id_cauhoi]});
	});

	$(document).on('click', '.add-dapan .themkhac', function(event) {
		let cauhoi = $(this).closest('.cauhoi');
		let loaicauhoi = cauhoi.find('.loaicauhoi').val();
		let id_cauhoi = cauhoi.attr('id');

		map_dapan_tong[id_cauhoi].push({id: `${Date.now()}`, noidung: 'Ý kiến khác:', giatri: false, thutu: thutu_dapan_themkhac, tunhap: true});
		renderCheckAnswer(cauhoi, {'loaicauhoi': loaicauhoi, 'dapan': map_dapan_tong[id_cauhoi]});
	});

	$(document).on('change', '.loaicauhoi', function(event) {
		let loaicauhoi = $(this).val();
		let cauhoi = $(this).closest('.cauhoi');
		let id_cauhoi = cauhoi.attr('id');
		let dapan_cauhoi = '';

		if (loaicauhoi === 'traloingan' || loaicauhoi === 'doan') {
			dapan_cauhoi = map_dapan[loaicauhoi];
		}else{
			if (!map_dapan_tong.hasOwnProperty(id_cauhoi)) {
				map_dapan_tong[id_cauhoi] = [{id: `${Date.now()}`, noidung: 'Đáp án 1', giatri: false, thutu: 0, tunhap: false}];
			}

			dapan_cauhoi = map_dapan_tong[id_cauhoi];
		}

		renderAnswerOfQuestion(cauhoi, {'loaicauhoi': loaicauhoi, 'dapan': dapan_cauhoi});
	});

	$(document).on('change', '.giatri-dapan', function(event) {
		let id_dapan = $(this).attr('id-dapan');
		let cauhoi = $(this).closest(".cauhoi");
		let id_cauhoi = cauhoi.attr('id');
		let giatri_dapan = $(this).prop('checked');

		let new_dapan_cauhoi = map_dapan_tong[id_cauhoi].map(function(da) {
			if (da.id === id_dapan) {
				da.giatri = giatri_dapan;
			}
			return da;
		});
		map_dapan_tong[id_cauhoi] = new_dapan_cauhoi;

		// renderAnswerOfQuestion(cauhoi, {'loaicauhoi': cauhoi.find('.loaicauhoi').val(), 'dapan': new_dapan_cauhoi});
	});

	$(document).on('click', '.btn-xoadapan', function(event) {
		let id_dapan = $(this).attr('id-dapan');
		let cauhoi = $(this).closest(".cauhoi");
		let id_cauhoi = cauhoi.attr('id');

		let new_dapan_cauhoi = map_dapan_tong[id_cauhoi].filter(function(da) {
			return da.id !== id_dapan;
		});

		map_dapan_tong[id_cauhoi] = new_dapan_cauhoi;

		renderAnswerOfQuestion(cauhoi, {'loaicauhoi': cauhoi.find('.loaicauhoi').val(), 'dapan': new_dapan_cauhoi});
	});

	$(document).on('change', '.noidung-dapan-input', function(event) {
		let id_dapan = $(this).attr('id-dapan');
		let cauhoi = $(this).closest(".cauhoi");
		let id_cauhoi = cauhoi.attr('id');
		let noidung_dapan = $(this).val();

		let new_dapan_cauhoi = map_dapan_tong[id_cauhoi].map(function(da) {
			if (da.id === id_dapan) {
				da.noidung = noidung_dapan;
			}
			return da;
		});
		map_dapan_tong[id_cauhoi] = new_dapan_cauhoi;

		// renderAnswerOfQuestion(cauhoi, {'loaicauhoi': cauhoi.find('.loaicauhoi').val(), 'dapan': new_dapan_cauhoi});
	});

	$(document).on('click', '.xoa-cauhoi', function(event) {
		let cauhoi = $(this).closest(".cauhoi");
		let id_cauhoi = cauhoi.attr('id');

		swal({   
            title: "Xóa câu hỏi này?",   
            text: "Khi xóa sẽ không thể khôi phục lại!",   
            type: "warning",   
            showCancelButton: true,   
            confirmButtonColor: "#DD6B55",   
            confirmButtonText: "Đồng ý, xóa nó!",
            closeOnConfirm: true 
        }, function(){   
            delete map_dapan_tong[id_cauhoi];
            cauhoi.remove();
        });
	});

	$(document).on('click', '.copy-cauhoi', function(event) {
		let cauhoi_root = $(this).closest(".cauhoi");
		let id_cauhoi = cauhoi_root.attr('id');
		let loaicauhoi = cauhoi_root.find('.loaicauhoi').val();
		let giatri_cauhoi = cauhoi_root.find('.giatri-cauhoi').prop('checked');
		let dapan_cauhoi = '';
		let id_cauhoi_clone = `${Date.now()}`;
		let cauhoi_clone = $(cauhoi_mau);
		let noidung_cauhoi_clone = `${cauhoi_root.find('.noidung-cauhoi-input').val()} clone`;
		cauhoi_clone.find('.noidung-cauhoi-input').val(noidung_cauhoi_clone);
		cauhoi_clone.find('.noidung-cauhoi-label').html(noidung_cauhoi_clone);
		cauhoi_clone.find('.loaicauhoi').val(loaicauhoi);

		if (loaicauhoi === 'traloingan' || loaicauhoi === 'doan') {
			dapan_cauhoi = map_dapan[loaicauhoi];
		}else{
			dapan_cauhoi_cu = map_dapan_tong[id_cauhoi];
			let id_dapan = Date.now();
			dapan_cauhoi = dapan_cauhoi_cu.map( (da) => {
				da.id = `${id_dapan++}`;
				return da;
			})
			map_dapan_tong[id_cauhoi_clone] = dapan_cauhoi;
		}

		cauhoi_clone.attr('id', id_cauhoi_clone);
		cauhoi_clone.insertAfter(`#${id_cauhoi}`);
		cauhoi_clone.find('.giatri-cauhoi').bootstrapToggle(giatri_cauhoi ? 'on' : 'off');

		renderAnswerOfQuestion(cauhoi_clone, {'loaicauhoi': loaicauhoi, 'dapan': dapan_cauhoi});
	});

	$(document).on('click', function(event) {
		if (!isClickRemove) {
			if (!$(event.target).closest("#add-cauhoi").length) {
				$('.cauhoi').removeClass('focus-cauhoi');
			}
			if($(event.target).closest(".cauhoi").length){
				onFocusCauHoi($(event.target).closest(".cauhoi"));
	        }
		}else{
			isClickRemove = !isClickRemove;
		}
	});

	$(document).on('click', '.topic .main', function(event) {
		let topic = $(this).closest('.topic');
		if (topic.hasClass('active') || topic.find('.child').first().html().trim() !== '') {
			return;
		}

		$('.cauhoi-container').block({
            message: `<h4><i class="fa fa-spin fa-spinner"></i> Đang tải dữ liệu...</h4>`,
            css: {
                border: '1px solid #fff'
        	}
    	});
		if (!topic.hasClass('active')) {
			$('#list-topic .topic').removeClass('active');
			topic.addClass('active');
		}

		if ($('.tacvu').hasClass('hidden')) {
			$('.tacvu').removeClass('hidden')
		}

		let id_topic = topic.attr('id');
    	$('#luu').attr('topic-id', id_topic);

		$('ul.topic-content').empty();
		getQuestionOfTopic(id_topic);
		setTimeout(function(){
			$('.cauhoi-container').unblock();
		}, 300);
	});

	function getQuestionOfTopic(id_topic){
		$.ajax({
			url: window.location.href,
			type: 'POST',
			dataType: 'json',
			data: {
				action: 'load-topic-question',
				topic: id_topic,
				[getCsrf().name]: getCsrf().hash
			},
		})
		.done(function(res) {
			let list_question = res;

			if (list_question.length > 0) {
				handleRenderListQuestion(list_question);
			}else{
				let html_empty_topic = 
				`<li class="empty-topic">
					<div class="alert alert-warning alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        Chủ đề này chưa có câu hỏi <i class="fa fa-spin fa-spinner"></i>
                    </div>
				</li>`;
				$('ul.topic-content').empty();
				$('ul.topic-content').html(html_empty_topic);
			}
		})
		.fail(function(err) {
			console.log(err);
			console.log("error");
		})
		.always(function() {

		});
		
	}

	$('#container').removeClass('container');
	$('#container').addClass('container-fluid');

	function handleRenderListQuestion(list_question){
		list_question.forEach( question => {
			handleRenderQuestion(question);
		});
	}

	function handleRenderQuestion(question){
		let id_cauhoi = question.ma_cauhoi;
		let dapan_cauhoi = '';
		let cauhoi = $(cauhoi_mau);

		cauhoi.find('.noidung-cauhoi-input').val(question.noidung_cauhoi);
		cauhoi.find('.noidung-cauhoi-label').html(question.noidung_cauhoi);
		cauhoi.find('.loaicauhoi').val(question.ma_loaicauhoi);

		if (question.ma_loaicauhoi === 'traloingan' || question.ma_loaicauhoi === 'doan') {
			dapan_cauhoi = map_dapan[question.ma_loaicauhoi];
		}else{
			dapan_cauhoi = question.da.map( da => {
				return {
					id: `${da.ma_dapan}`,
					noidung: da.noidung_dapan,
					giatri: (da.giatri_dapan == '1'),
					thutu: da.thutu_dapan,
					tunhap: (da.noidung_tunhap == '1'),
				};
			});
			map_dapan_tong[id_cauhoi] = dapan_cauhoi;
		}

		cauhoi.attr('id', `${id_cauhoi}`);
		$('ul.topic-content').append(cauhoi);
		cauhoi.find('.giatri-cauhoi').bootstrapToggle(question.tinhdiem === '1' ? 'on' : 'off');
		renderAnswerOfQuestion(cauhoi, {'loaicauhoi': question.ma_loaicauhoi, 'dapan': dapan_cauhoi});
	}

	$(document).on('click', '#luu', function(event) {
		let id_topic = $(this).attr('topic-id');
		if (id_topic === undefined) {
			return;
		}

		let topic_question = [];

		$('ul.topic-content .cauhoi').each( (index, cauhoi) => {
			topic_question.push(getCauHoi($(cauhoi), index, id_topic));
		});

		saveTopicQuestion(id_topic, topic_question);
	});

	function saveTopicQuestion(id_topic, topic_question){
		$.ajax({
			url: window.location.href,
			type: 'POST',
			dataType: 'JSON',
			data: {
				action: 'save-topic-question',
				topic: id_topic,
				question: JSON.stringify(topic_question),
				[getCsrf().name]: getCsrf().hash
			},
		})
		.done(function(res) {
			showMessage('success', 'Đã lưu các câu hỏi');
		})
		.fail(function(err) {
			console.log(err);
			showMessage('error', 'Đã có lỗi xảy ra, vui lòng thử lại');
		})
		.always(function() {
			console.log("complete");
		});
	}

	function getCauHoi(cauhoi, index, id_topic){
		let loaicauhoi = cauhoi.find('.loaicauhoi').val();
		let obj_cauhoi = {
			'ma_cauhoi': cauhoi.attr('id'),
			'noidung_cauhoi': cauhoi.find('.noidung-cauhoi-input').val().trim(),
			'thutu_cauhoi': index,
			'ma_nhomcauhoi': id_topic,
			'ma_loaicauhoi': cauhoi.find('.loaicauhoi').val().trim(),
			'tinhdiem': cauhoi.find('.giatri-cauhoi').prop('checked') ? '1' : '0',
		}

		let list_dapan = [];
		if (['tracnghiem', 'hopkiem'].indexOf(obj_cauhoi.ma_loaicauhoi) !== -1) {
			list_dapan = getAnswerOfQuestion(cauhoi);
		}

		return {cauhoi: obj_cauhoi, dapan: list_dapan};
	}

	function getAnswerOfQuestion(cauhoi){
		let list_answer = [];
		let id_cauhoi = cauhoi.attr('id');

		cauhoi.find('.dapan').each( (index, dapan) => {
			list_answer.push(getAnswer($(dapan), index, id_cauhoi));
		});

		return list_answer;
	}

	function getAnswer(dapan, index, id_cauhoi){
		let obj_dapan = {
			'ma_dapan': dapan.attr('id'),
			'noidung_dapan': dapan.find('.noidung-dapan-input').val(),
			'thutu_dapan': (dapan.find('.tunhap').length > 0) ? 1000 : index,
			'noidung_tunhap': dapan.find('.tunhap').length,
			'giatri_dapan': dapan.find('.giatri-dapan').prop('checked') ? '1' : '0',
			'ma_cauhoi': id_cauhoi,
		}

		return obj_dapan;
	}
});