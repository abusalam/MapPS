
<div class="page_head">
	
	<table width="100%" class="" cellspacing="0">
<tr>
	<td><h2>POLLING STATIONS</h2></td>
	
</tr>	
</table>
</div>	
 <div class="filtering shadow">
    <form>	
	AC NO : <input type="text" name="ac_no" id="ac_no" />
	PS NO : <input type="text" name="ps_no" id="ps_no" />
	
	<button type="submit" id="LoadRecordsButton">Filter</button></form>
</div>
<div id="AcTable"></div>
	<script type="text/javascript">

		$(document).ready(function () {

		    //Prepare jTable
			$('#AcTable').jtable({
				title: 'AC LIST',
				selecting: true, //Enable selecting
				multiselect: false,
               // selectingCheckboxes: true, //Show checkboxes on first column
				paging: true,
				pageSize: 10,
				sorting: true,
				defaultSorting: 'ps_no ASC',
				
				actions: {
					listAction: '../Controllers/Ps.php?action=list',
					createAction: '../Controllers/Ps.php?action=create',
					updateAction: '../Controllers/Ps.php?action=update',
					deleteAction: '../Controllers/Ps.php?action=delete'
									
				},
				fields: {
					ps_id: {key: true,	create: false,	edit: false,list: false},
					ac_no: {	title: 'AC NO', options: { <?php 
						$sql="SELECT ac_no,ac_name FROM ac   ORDER BY ac_name";
					$res=mysql_query($sql) or die("Unable to connect to Server, We are sorry for inconvienent caused".mysql_error());
						while($row=mysql_fetch_array($res))
	
						echo "'".$row['ac_no']."':'".$row['ac_no']."-".$row['ac_name']."',";
						?>
					 }},
					ps_no: {	title: 'PS NO',width:'5%'},
					ps_name: {	title: 'PS NAME',},
					lat: {	title: 'LATITUDE',width:'5%'},
					lon: {	title: 'LONGITUDE',width:'5%'},
					bdo_office: {	title: 'BDO OFFICE',width:'5%'},
					bdo_no: {	title: 'CONTACT',width:'5%'},
					pro_mobile_no: {	title: 'PRO MOBILE',width:'5%'},
					p1_mobile_no: {	title: 'P1 MOBILE',width:'5%'},
					sector_officer_name: {	title: 'SECTOR OFFICER',},
					sector_officer_mobile: {	title: 'SECTOR MOBILE NO',},
					vulnerable_ps: {	title: 'VULNERABLE',width:'5%'},
					critical_ps: {	title: 'CRITICAL',width:'2%'},
					lwe: {	title: 'LWE',width:'5%'},
					mobile_shadow_zone: {	title: 'MOB. SHADOW',width:'5%'},
					vst_name: {	title: 'VST PERSON',width:'5%'},
					vst_mobile: {	title: 'VST MOBILE',width:'5%'},
					sst_name: {	title: 'SST PERSON',width:'5%'},
					sst_mobile: {	title: 'SST MOBILE',width:'5%'},
					fs_name: {	title: 'FQ PERSON',width:'5%'},
					fs_mobile: {	title: 'FQ MOBILE',width:'5%'}
					
					
					
					
					
				},
			

		 formCreated: function (event, data) {
              
                
                data.form.find('input[name="ac_no"]').addClass('validate[required]');
                data.form.find('input[name="ps_no"]').addClass('validate[required]');
                data.form.find('input[name="lat"]').addClass('validate[required,custom[number]]');
                data.form.find('input[name="lon"]').addClass('validate[required]');
                data.form.find('input[name="sector_officer_name"]').addClass('validate[required]');
                data.form.find('input[name="sector_officer_mobile"]').addClass('validate[required]');
                            
                data.form.validationEngine();
            },
            //Validate form when it is being submitted
            formSubmitting: function (event, data) {
                return data.form.validationEngine('validate');
            },
            //Dispose validation logic when form is closed
            formClosed: function (event, data) {
                data.form.validationEngine('hide');
                data.form.validationEngine('detach');
            },
			recordsLoaded: function(event, data) {
				$('.jtable-data-row').click(function() {
					var row_id = $(this).attr('data-record-key');
					$("#ac_no_select").val(row_id);
				});
			}
			
});

 //$('#AcTable').jtable('load');
 //Re-load records when user click 'load records' button.
        $('#LoadRecordsButton').click(function (e) {
           e.preventDefault();
           $('#AcTable').jtable('load', {
               ac_no: $('#ac_no').val(),
               ps_no: $('#ps_no').val(),
           });
        });
 
        //Load all records when page is first shown
        $('#LoadRecordsButton').click();
    });
	</script>
	<input type="hidden" id="ac_no_select" />
