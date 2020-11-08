<div class="panel panel-default m-t-5">
   <div class="panel-heading text-uppercase text-center">
      <p>THÊM NHIỀU SINH VIÊN</p>
   </div>
   <div class="panel-wrapper collapse in">
      <div class="panel-body">
         <form method="POST" action="" enctype="multipart/form-data" data-toggle="validator">
            <div class="col-sm-5">
               <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                  <div class="form-control" data-trigger="fileinput"> 
                     <i class="glyphicon glyphicon-file fileinput-exists"></i> 
                     <span class="fileinput-filename"></span>
                  </div>
                  <span class="input-group-addon btn btn-default btn-file"> 
                  <span class="fileinput-new">Thêm file</span> <span class="fileinput-exists">Sửa</span>
                  <input type="file" name="insert_excel" accept=".xlsx, .xls"  id="uploadExcel" required=""> </span> <a href="javascript:void(0)" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Xóa</a> 
               </div>
            </div>
            <button type="submit" name="action" value="themsinhvien" class="btn btn-success waves-effect waves-light" data-toggle="modal">
            <span class="btn-label">
            <i class="fa fa-plus"></i>
            </span>Upload
            </button>
            <a class="btn btn-info waves-effect waves-light pull-right" href="uploads/Mau_import_sinh_vien.xlsx?ver=1.0" name="excel" title="File Excel mẫu">
            <i class="fa fa-download"></i> File Excel mẫu
            </a>
         </form>
         <br>
         {if isset($dssv_err)}
         <h3 class="text-info text-center">DANH SÁCH SINH VIÊN KHÔNG HỢP LỆ</h3>
         <hr>
         <br>
         <div class="row">
            <div class="col-md-12">
               <table id="myTable" class="table table-bordered datatable">
                  <thead>
                     <tr>
                        <th class="text-center" style="width: 100px;">STT</th>
                        <th class="text-center">Mã sinh viên</th>
                        <th class="text-center">Tên sinh viên</th>
                        <th class="text-center">Giới tính</th>
                        <th class="text-center">Ngày sinh</th>
                        <th class="text-center">Email</th>
                        <th class="text-center">Số điện thoại</th>
                        <th class="text-center">Tên lớp</th>
                        <th class="text-center">Trạng thái</th>
                     </tr>
                  </thead>
                  <tbody>
                     {foreach $dssv_err as $k => $v}
                     <tr>
                        <td class="text-center">{$k+1}</td>
                        <td class="text-center">
                           {if !in_array($v[0], $masinhvien)}{$v.0}{else}
                           <p style="color: red; ">{$v.0}</p>
                           {/if}
                        </td>
                        <td>{$v.1}</td>
                        <td class="text-center">{$v.2}</td>
                        <td class="text-center">{$v.3}</td>
                        <td class="text-center">{$v.4}</td>
                        <td class="text-center">{$v.5}</td>
                        <td  class="text-center">
                           {if isset($lopconfig[$v[6]])}{$v.6}{else}
                           <p style="color: red; ">{$v.6}</p>
                           {/if}
                        </td>
                        <td>
                           {if isset($trangthaiconfig[$v[7]])}{$v.7}{else}
                           <p style="color: red; ">{$v.7}</p>
                           {/if}
                        </td>
                     </tr>
                     {/foreach}
                  </tbody>
               </table>
            </div>
         </div>
         {/if}
      </div>
   </div>
</div>
<script src="{$url}assets/js/jasny-bootstrap.js"></script>
<script src="{$url}assets/template/js/validator.js"></script>