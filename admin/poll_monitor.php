<script>

function ActionScript(act)
{
if($("#con_id").val()=="" && act !="add")
	  alert("Please select an Employee");
else
	{
		url="pages.php?src=masters/consultant.php&act="+act+"&con_id="+$("#con_id").val();
		location.href=url;
		
	}
	
		
}
</script>
<script>
 function loadlist(selobj,url,nameattr,valueattr)
{
    $(selobj).empty();
    $.getJSON(url,{},function(data)
    {$(selobj).append($('<option></option>').val('').html('--Please Select--'));
        $.each(data, function(i,obj)
        {
             
             $(selobj).append($('<option></option>').val(obj[valueattr]).html(obj[valueattr]+" "+obj[nameattr]));
        });
    });
}

function select_sec()
   {
  
    var ac=$('select#ac').val();
	if(ac!="")
    loadlist($('select#sector_no').get(0),'../Controllers/sector_list.php?ac='+ac+'','sector_name','sector_no');
	else
    $('select#sector_no').empty();
   }

	</script>
	<script>
 function loadlistPC(selobj,url,nameattr,valueattr)
{
    $(selobj).empty();
    $.getJSON(url,{},function(data)
    {$('select#ac').append($('<option></option>').val('').html('--Select All--'));
        $.each(data, function(i,obj)
        {
             
             $(selobj).append($('<option></option>').val(obj[valueattr]).html(obj[valueattr]+" "+obj[nameattr]));
        });
    });
}

function select_PC()
   {
  
    var pc=$('select#pc').val();
	if(pc!="")
		loadlistPC($('select#ac').get(0),'../Controllers/ac_list.php?pc='+pc+'','ac_name','ac_no');
	else
	{
		$('select#ac').empty();
		$('select#ac').append($('<option></option>').val('').html('--Select All--'));
		}
   }
   </script>
<div>
	
	<table width="100%" class="" cellspacing="0">
<tr>
	<td><h2>POLL MONITORING</h2></td>
	
</tr>	
</table>
</div>	
 <div class="filtering shadow">
    <form>	
	PC:<select name="pc" id="pc" style="width:150px"  onchange="select_PC();">
					
						<option value="" selected>--Please select--</option>
						<option value="33" >33-Jhargram</option>
						<option value="34" >34-Medinipur</option>
						<option value="32" >32-Ghatal</option>
					</select>
				AC:<select name="ac" id="ac" style="width:150px"  onchange="select_sec();">
								<option value="" >All</option>
				
				</select>
				SECTOR NO/NAME :<select name="sector_no" id="sector_no" style="width:150px" ></select>
				PS NO :<input type="text" class="input-mini" name="ps_no" id="ps_no"  />
				POLL STAT :<select name="poll_stat" id="poll_stat" style="width:150px">
					
						<option value="" selected>--Please select--</option>
						<option value="N" >Yet to Start</option>
						<option value="S" >Started</option>
						<option value="E" >Ended</option>
					</select>
					
					
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
					listAction: '../Controllers/Poll_Update.php?action=list',
					updateAction: '../Controllers/Poll_Update.php?action=update'
									
				},
							
				fields: {
					ps_id: {key: true,	create: false,	edit: false,list: false},
					ac_no: {	title: 'AC NO', options: { <?php 
						$sql="SELECT ac_no,ac_name FROM ac   ORDER BY ac_name";
					$res=mysql_query($sql) or die("Unable to connect to Server, We are sorry for inconvienent caused".mysql_error());
						while($row=mysql_fetch_array($res))
	
						echo "'".$row['ac_no']."':'".$row['ac_no']."-".$row['ac_name']."',";
						?>
					 },create: false,	edit: false,},
					ps_no: {	title: 'PS NO',width:'5%',create: false,	edit: false,},
					ps_name: {	title: 'PS NAME',create: false,	edit: false,},
					bdo_office: {	title: 'BDO OFFICE',width:'5%',create: false,	edit: false,},
					bdo_no: {	title: 'CONTACT',width:'5%',create: false,	edit: false,},
					sector_officer_name: {	title: 'SECTOR OFFICER',create: false,	edit: false,},
					sector_officer_mobile: {	title: 'SECTOR MOBILE NO',create: false,	edit: false,},
					mobile_shadow_zone: {	title: 'MOB. SHADOW',width:'5%',create: false,	edit: false,},
					poll_stat: {	title: 'POLL STAT',width:'5%'}
					
					
					
					
					
					
				},

		 formCreated: function (event, data) {
              
                
                data.form.find('input[name="ac_no"]').addClass('validate[required]');
                data.form.find('input[name="ps_no"]').addClass('validate[required]');
                data.form.find('input[name="lat"]').addClass('validate[required]');
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
               pc_no: $('#pc').val(),
               ac_no: $('#ac').val(),
               ps_no: $('#ps_no').val(),
               sector_no: $('#sector_no').val(),
               poll_stat: $('#poll_stat').val()
           });
        });
 
        //Load all records when page is first shown
        $('#LoadRecordsButton').click();
    });
	</script>
	<input type="hidden" id="ac_no_select" />
	

