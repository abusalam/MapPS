
<div class="page_head">
	
	<table width="100%" class="" cellspacing="0">
<tr>
	<td><h2>Consultant List</h2></td>
	<td>
		
	</td>
</tr>	
</table>
</div>	
<div class="filtering shadow">
    <form>
	AC: <input type="text" name="ac_no" id="ac_no" />
	
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
				defaultSorting: 'pc_no ASC',
				
				actions: {
					listAction: '../Controllers/Ac.php?action=list',
					createAction: '../Controllers/Ac.php?action=create',
					updateAction: '../Controllers/Ac.php?action=update',
					deleteAction: '../Controllers/Ac.php?action=delete'
									
				},
				fields: {
					
					pc_no: {	title: 'PC NO',},
					pc_name: {	title: 'PC NAME',},
					ac_no: {key: true,	create: true,	edit: true,list: true,title: 'AC NO'},
					ac_name: {	title: 'AC NAME',},
					user_pass: {	title: 'Password',},
					
					
				},
			

		 formCreated: function (event, data) {
              
                
                data.form.find('input[name="pc_no"]').addClass('validate[required]');
                data.form.find('input[name="pc_name"]').addClass('validate[required]');
                data.form.find('input[name="ac_no"]').addClass('validate[required]');
                data.form.find('input[name="ac_name"]').addClass('validate[required]');
                data.form.find('input[name="user_pass"]').addClass('validate[required]');
              
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
               ac_no: $('#ac_no').val()
           });
        });
 
        //Load all records when page is first shown
        $('#LoadRecordsButton').click();
    });
	</script>
	<input type="hidden" id="ac_no_select" />


</body>
</html>