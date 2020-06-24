<?php
    $psu = $_GET['psu'];
?>
<!DOCTYPE html>
<html>
<head>
	<title>PSU - Selector - <?php echo $psu; ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="robots" content="noindex, nofollow">
    <meta name="robots" content="noarchive">
    <meta name="googlebot" content="noindex, nofollow" />
    <meta name="googlebot" content="noarchive">
    <link rel="stylesheet" type="text/css" media="screen" href="css/smoothness/jquery-ui.min.css" />
    <link rel="stylesheet" href="css/ui.jqgrid.css" type="text/css" />
    <link rel="stylesheet" type="text/css" media="screen" href="css/myjqgrid.css" />

    <script src="js/jquery-1.10.1.min.js" type="text/javascript"></script>
    <script src="js/i18n/grid.locale-en.js" type="text/javascript"></script>
    <script type="text/javascript" src="js/jquery.jqGrid.min.js"></script>
    <script src="js/exportExcel.js" type="text/javascript"></script>


   

</head>
<body>
<div>
	<table id="testgrid"></table>
    <span id="pager"></span>

    <form method="post" action="inc/csvexport.php">
        <input type="hidden" name="csvBuffer" id="csvBuffer" value="" />
    </form>
</div>	

	<script type="text/javascript">
		function init() {
			var $grid = $('#testgrid');

			$grid.jqGrid({
				url: "report.php?s=psu__<?php echo $psu; ?>",
				datatype: "xml",
				mtype: "GET",
				colNames:["Model", "Wattage", "80 PLUS<br>level", "Warranty<br>(y)", "Max<br>Eff.<br>(%)", "Length<br>Unit<br>(mm)", "Coating", "+12V<br>rails", "+12V<br>comb.<br>(W)", "+12V<br>ratio<br>(%)", "+3.3V<br>& +5V<br>comb.", "Fan<br>Size<br>(mm)", "Fan<br>Bearing", "C&C<br>(pdf)", "CPU<br>4-pin", "CPU<br>4+4-pin<br>& 8-pin", "PCI-E<br>6+2-pin<br>& 6-pin", "SATA", "Molex", ],
				colModel:[
					{name:"Model",index:"Model", width:120, xmlmap:"Model_Internal",stype:'none',formatter:"showlink"},
					{name:"Wattage",index:"Wattage", width:50, xmlmap:"P_Wattage_D",stype:'none'},
					{name:"80_PLUS_level",index:"80_PLUS_level", width:80, xmlmap:"P_80_PLUS_D",stype:'none'},
					{name:"Warranty_(y)",index:"Warranty_(y)", width:50, xmlmap:"P_Warranty_D",stype:'none'},
					{name:"Max_Efficiency",index:"Max_Efficiency", width:50, xmlmap:"P_Efficiency_Max_D",stype:'none'},
					{name:"Length_Unit_(mm)",index:"Length_Unit_(mm)", width:50, xmlmap:"Unit_Depth_mm",stype:'none'},
					{name:"Coating",index:"Coating", width:80, xmlmap:"P_Coating_D",stype:'none'},
					{name:"12V_rails",index:"12V_rails", width:50, xmlmap:"P_Rails_D",stype:'none'},
					{name:"P_Spec_12v_comb_W",index:"P_Spec_12v_comb_W", width:50, xmlmap:"P_Spec_12v_comb_W",stype:'none'},
					{name:"12V_ratio",index:"12V_ratio", width:50, xmlmap:"P_12V_Ratio_D",stype:'none'},
					{name:"P_Spec_33_and_5_comb",index:"P_Spec_33_and_5_comb", width:50, xmlmap:"P_Spec_33_and_5_comb",stype:'none'},
					{name:"Fan_Size",index:"Fan_Size", width:50, xmlmap:"P_Fan_Size_D",stype:'none'},
					{name:"Fan_Bearing",index:"Fan_Bearing", width:60, xmlmap:"P_Fan_Bearing_D",stype:'none'},
					{name:"P_Cable_Lengths_G_screen",index:"P_Cable_Lengths_G_screen", width:50, xmlmap:"P_Cable_Lengths_G_screen",stype:'none',formatter:'showlink'},
					{name:"CPU_4-pin",index:"CPU_4-pin", width:100, xmlmap:"P_Connector_CPU_4_D",stype:'none'},
					{name:"SUM_P_Connector_CPU_44_8",index:"SUM_P_Connector_CPU_44_8", width:100, xmlmap:"SUM_P_Connector_CPU_44_8",stype:'none'},
					{name:"SUM_P_Connector_PEG_6_62",index:"SUM_P_Connector_PEG_6_62", width:100, xmlmap:"SUM_P_Connector_PEG_6_62",stype:'none'},
					{name:"SATA",index:"SATA", width:50, xmlmap:"P_Connector_SATA_D",stype:'none'},
					{name:"Molex",index:"Molex", width:50, xmlmap:"P_Connector_Molex_D",stype:'none'}],
				height: (window.innerHeight-140) + 'px',
		        rowNum: 100000,
		        rowList: [100000, 10, 20, 50, 100],
				viewrecords: true,
				loadonce: true,
				xmlReader: {
						root : "data",
						row: "model",
						repeatitems: false
				},
				sortname: 'Model',
				viewrecords: true,
				rownumbers: false,
				sortorder: "desc",
				gridview : true,
				pager: '#pager',
				caption: "PSU - Selector - <?php echo $psu; ?>",
				loadComplete: function() {
					$("tr.jqgrow:odd").addClass('odd');
					$("option[value=100000]").text('All');
				}
			});
			//jQuery("#testgrid").jqGrid('filterToolbar');
			$grid.jqGrid('navGrid', '#pager',{view:false, del:false, add:false, edit:false, search:false, refresh:false, excel:true})
		    .navButtonAdd('#pager',{
		            caption:"Export to Excel", 
		            buttonicon:"ui-icon-save", 
		            onClickButton: function(){ 
		              exportExcel();
		            }, 
		            position:"last"
		    });

		}//end window onload
	    window.onload = init;

		$(window).resize(function () {
		  resizeGrid();
		});

		$(window).load(function() {
		  resizeGrid();
		});

		function resizeGrid() {
		  
		  var widthPadding = 10; 
		 
		  $('#testgrid').setGridWidth($(window).width() - widthPadding);
		}


	</script>

</body>
</html>