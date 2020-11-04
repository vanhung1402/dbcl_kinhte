<link href="{$url}assets/plugins/bower_components/sweetalert/sweetalert.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="{$url}assets/css/khaosat/chude.css">

<div class="panel panel-default block m-t-5">
    <div class="panel-heading text-center"> 
        CHỦ ĐỀ KHẢO SÁT
    </div>
    <div class="panel-wrapper collapse in" aria-expanded="true">
        <div class="panel-body">
			<div class="chude-container">
				<div class="form-material">
					<div id="handding-topic">

					</div>
					<button class="fcbtn btn btn-xs btn-info btn-outline btn-1d" id="add-main-topic">
						<i class="fa fa-plus m-r-15"></i> THÊM CHỦ ĐỀ CHÍNH
					</button>
				</div>
				<div class="button-action text-center m-t-30">
					<div class="form-group">
						<button class="btn btn-success waves-effect waves-light" type="button" id="luu">
							<span class="btn-label">
								<i class="fa fa-check"></i>
							</span>
							LƯU THAY ĐỔI
						</button>
					</div>
					&nbsp;&nbsp;&nbsp;
					<div class="form-group">
						<a href="{$url}cauhoi?khaosat={$ma_khaosat}" class="btn btn-info waves-effect waves-light">
							<span class="btn-label">
								<i class="fa fa-plus"></i>
							</span>
							QUẢN LÝ CÂU HỎI
						</a>
					</div>
				</div>
			</div>
        </div>
    </div>
</div>

<input type="hidden" class="csrf" name="{$csrf_token_name}" value="{$csrf_token}"/>
<script src="{$url}assets/plugins/bower_components/sweetalert/sweetalert.min.js"></script>
<script type="text/javascript">
	const ma_khaosat = '{$ma_khaosat}';
</script>
{literal}
<script type="text/javascript">
	$(document).ready(function() {
		let id_topic_focus = null;
		let recursion_topic = [];
		let array_topic_new = [];
		let array_topic_del = [];

		const pattern_topic = 
		`<div class="topic form-group">
			<input name="index" type="text" class="index-topic form-control" title="Chỉ mục cho chủ đề" placeholder="..."/>. &nbsp;
			<input name="title" type="text" class="title-topic form-control" placeholder="Nội dung chủ đề">
			<div class="manage-topic form-group">
				<button class="btn btn-sm action add-child" value="add-child" title="Thêm chủ đề con cho mục này">
					<i class="ti-plus"></i>
				</button>
				<button class="btn btn-sm remove-topic" title="Xóa chủ đề này">
					<i class="ti-trash"></i>
				</button>
				<button class="btn btn-sm action move-up" value="up" title="Di chuyển lên">
					<i class="ti-angle-up"></i>
				</button>
				<button class="btn btn-sm action move-down" value="down" title="Di chuyển xuống">
					<i class="ti-angle-down"></i>
				</button>
			</div>
			<div class="child">
			</div>
		</div>`;

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
						sort: topic.thutu_nhomcauhoi,
						has_question: topic.ma_cauhoi,
					};
				})

				recursion_topic = normalToRecursion(array_normal);
			})
			.fail(function(err) {
				console.log(err);
				showMessage('error', 'Đã có lỗi xảy ra, vui lòng tải lại sau!');
			})
			.always(function() {
				renderTopic($('#handding-topic'), recursion_topic);
			});
		}

		function sortTopic(a, b){
			return Number(a.sort) - Number(b.sort);
		}

		function renderTopic(root, list_topic){
			let sort_topic = list_topic.sort(sortTopic)

			sort_topic.forEach( function(topic) {
				let topic_obj = $(`${pattern_topic}`);
				topic_obj.attr('id', topic.id);
				topic_obj.find('.index-topic').val(topic.index);
				topic_obj.find('.title-topic').val(topic.title);
				topic_obj.find('.remove-topic').attr('topic-id', topic.id);
				if (topic.has_question !== undefined && topic.has_question !== null) {
					topic_obj.find('.remove-topic').attr({
						'disabled': true,
						'title': 'Không thể xóa chủ đề này'
					});
				}
				topic_obj.find('.action').attr('topic-id', topic.id);
				topic_obj.find('input').attr('topic-id', topic.id);

				if (topic.child !== undefined) {
					renderTopic(topic_obj.find('.child'), topic.child);
				}

				root.append(topic_obj);
			});
		}

		function renderMainTopic(){
			$('#handding-topic').empty();

			renderTopic($('#handding-topic'), recursion_topic);
		}

		function removeTopic(list_topic, id_topic_remove){
			list_topic.forEach( function(topic, index) {
				if (topic.id === id_topic_remove) {
					delete list_topic[index];
				}else if (topic.child !== undefined) {
					removeTopic(topic.child, id_topic_remove);
				}
			});
		}

		function focusTopic(){
			$(`#${id_topic_focus} .index-topic`).first().focus();
			id_topic_focus = null;
		}

		function isTopic(topic){
			return topic.id === this.id;
		}

		function changeSortTopic(options){
			let {val, id_topic} = options;
			let array_topic_normal = recursionToNormal(recursion_topic);
			let map_topic_normal = initMapTopic(array_topic_normal);
			switch (val) {
				case 'up':
				case 'down':{
					let id_parent = array_topic_normal.find(isTopic, {id: id_topic}).parent;
					let parent = map_topic_normal[id_parent];

					map_topic_normal[id_parent] = handleChangeTopic(parent.sort(sortTopic), options);

					break;
				}
					
				case 'add-child':{
					let list_topic = map_topic_normal[id_topic];
					map_topic_normal[id_topic] = handleChangeTopic(list_topic, options);

					break;
				}

				default:
					break;
			}
			recursion_topic = mapToRecursion(map_topic_normal);

			renderMainTopic();
		}

		function handleChangeTopic(parent, options){
			let {val, id_topic} = options;
			switch (val) {
				case 'up':
				case 'down':{
						for(let i = 0; i < parent.length; i++){
							if (parent[i].id === id_topic) {
								if (val === 'up' && i > 0) {
									let temp = parent[i].sort;
									parent[i].sort = parent[i - 1].sort;
									parent[i - 1].sort = temp;
								}else if (val === 'down' && i < parent.length - 1) {
									let temp = parent[i].sort;
									parent[i].sort = parent[i + 1].sort;
									parent[i + 1].sort = temp;
								}
							}
						}

					id_topic_focus = id_topic;
					break;
				}
				case 'add-child':{
					let sort_max = 0;
					let id_topic_new = `${ma_khaosat}${Date.now()}`;
					if (parent) {
						parent.forEach( topic => {
							sort_max = (topic.sort > sort_max) ? topic.sort : sort_max;
						});
					}else{
						parent = [];
					}

					parent.push({
						id: id_topic_new,
						title: '',
						index: '',
						sort: `${Number(sort_max) + 1}`,
					});

					array_topic_new.push(id_topic_new);

					id_topic_focus = id_topic_new;
					break;
				}
				default:
					break;
			}
			return parent.sort(sortTopic);
		}

		function recursionToNormal(array_recursion){
			let array_normal = [];

			if (!array_recursion) {
				return [];
			}

			function parseRecursion(recursion, parent_id){
				recursion.forEach( function(topic, index) {
					array_normal.push({
						id: topic.id,
						title: topic.title,
						index: topic.index,
						sort: topic.sort,
						parent: parent_id,
						has_question: topic.has_question
					})

					if (topic.child !== undefined) {
						parseRecursion(topic.child, topic.id);
					}
				});
			}

			parseRecursion(array_recursion, ma_khaosat);

			normalToRecursion(array_normal);
			return array_normal;
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

		function normalToRecursion(array_normal){
			let map_normal = initMapTopic(array_normal);

			return mapToRecursion(map_normal);
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

		function checkArrayTopicNormal(array_topic_normal){
			let check = true;

			for (var i = 0; i < array_topic_normal.length; i++) {
				let topic = array_topic_normal[i];
				if (topic.title === '') {
					check = false;
					$(`#${topic.id}`).find('.title-topic').first().focus();
					showMessage('warning', 'Không được bỏ trống tiêu đề!');
					return false;
				}
			}

			return check;
		}

		function getAllIdChildTopic(id_parent, array_topic_normal){
			let list_id_child = [];
			let list_id_parent = [id_parent];

			while (list_id_parent.length > 0) {
				let id_parent = list_id_parent.shift();
				array_topic_normal.forEach( topic => {
					if (topic.parent === id_parent) {
						list_id_child.push(topic.id);
						list_id_parent.push(topic.id);
					}
				});
			}

			return list_id_child;
		}

		function handingRemoveTopic(id_topic){
			array_topic_del.push(id_topic);

			let array_topic_normal = recursionToNormal(recursion_topic);
			array_topic_del = array_topic_del.concat(getAllIdChildTopic(id_topic, array_topic_normal));
		}
		function saveTopic(array_topic){
			let array_save = array_topic.map(function(topic) {
				return {
					ma_nhomcauhoi: topic.id,
					chimuc_nhomcauhoi: topic.index,
					ten_nhomcauhoi: topic.title,
					ma_nhomcha: topic.parent,
					thutu_nhomcauhoi: topic.sort,
					ma_khaosat: ma_khaosat
				};
			});

			$.ajax({
				url: window.location.href,
				type: 'POST',
				dataType: 'JSON',
				data: {
					action: 'save-topic',
					save: JSON.stringify(array_save),
					new: JSON.stringify(array_topic_new),
					del: JSON.stringify(array_topic_del),
					[getCsrf().name]: getCsrf().hash
				},
			})
			.done(function(res) {
				console.log(res);
				let data = JSON.parse(res);
				if (data > 0) {
					showMessage('success', 'Đã lưu các chủ đề');
					window.location.reload();
				}else{
					showMessage('warning', 'Không có thay đổi nào được ghi nhận');
				}
			})
			.fail(function(err) {
				console.log(err);
				showMessage('error', 'Đã có lỗi xảy ra, vui lòng thử lại sau!');
			})
			.always(function() {
			});
		}

		$(document).on('click', '.remove-topic', function(event) {
			let id_topic_remove = $(this).attr('topic-id');

			swal({   
	            title: "Xóa chủ đề này?",   
	            text: "Hãy chắc chắn, nếu xóa chủ đề này thì các câu hỏi thuộc chủ đề sẽ bị xóa theo và không thể khôi phục!",   
	            type: "warning",   
	            showCancelButton: true,   
	            confirmButtonColor: "#DD6B55",   
	            confirmButtonText: "Đồng ý, xóa nó!",
	            closeOnConfirm: true 
	        }, function(){
				handingRemoveTopic(id_topic_remove);

	            removeTopic(recursion_topic, id_topic_remove);
				renderMainTopic();
	        });
		});
		
		$(document).on('click', '.action', function(event) {
			let sort_options = {
				val: $(this).val(),
				id_topic: $(this).attr('topic-id'),
			}

			changeSortTopic(sort_options);

			focusTopic();
		});

		$(document).on('click', '#add-main-topic', function(event) {
			let sort_max = 0;
			let id_topic_new = `${ma_khaosat}${Date.now()}`;

			if (recursion_topic.length > 0) {
				if (recursion_topic.length === 1) {
					sort_max = recursion_topic[0].sort;
				}else{
					recursion_topic.forEach( topic => {
						sort_max = (topic.sort > sort_max) ? topic.sort : sort_max;
					});
				}
			}

			recursion_topic.push({
				id: id_topic_new,
				title: '',
				index: '',
				sort: `${Number(sort_max) + 1}`,
			});

			array_topic_new.push(id_topic_new);

			renderMainTopic();

			id_topic_focus = id_topic_new;
			focusTopic();
		});

		$(document).on('click', '#luu', function(event) {
			$(this).closest('.block').block({
	            message: `<h4><img src="${url}assets/plugins/images/busy.gif" /> Just a moment...</h4>`,
	            css: {
	                border: '1px solid #fff'
            	}
        	});

        	if (recursion_topic.length > 0) {
        		let array_topic_normal = recursionToNormal(recursion_topic);

        		if (checkArrayTopicNormal(array_topic_normal)) {
        			saveTopic(array_topic_normal);
        		}
        	}else{
        		showMessage('warning', 'Danh sách chủ đề trống');
        	}

        	$(this).closest('.block').unblock();
		});

		$(document).on('change', '.topic input', function(event) {
			let name = $(this).attr('name');
			let id_topic = $(this).attr('topic-id');
			let array_normal = recursionToNormal(recursion_topic);

			for (var i = 0; i < array_normal.length; i++) {
				if (array_normal[i].id === id_topic) {
					if (name === 'index') {
						array_normal[i].index = $(this).val().trim();
					} else if (name === 'title') {
						array_normal[i].title = $(this).val().trim();;
					}
				}
			}

			recursion_topic = normalToRecursion(array_normal);
		});
	});
</script>
{/literal}
