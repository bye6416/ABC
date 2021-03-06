	<script type="text/javascript" src="./js/jquery.js"></script>
    <script type="text/javascript" src="./js/ui.core.js"></script>
    <script type="text/javascript" src="./js/ui.sortable.js"></script>
    <script type="text/javascript" src="./js/jquery.cookie.js"></script>
    <style type="text/css">
        .column{
            float: left;
            width: 200px;
            padding-bottom: 100px;
        }
        .portlet{
            margin: 0 1em 1em 0;
            border: 1px solid #C031C7;
            height:170px;
        }
        .portlet-header{
            margin: 0.3em;
            padding-bottom: 4px;
            padding-left: 0.2em;
            cursor: move;
            background: #646D7E;
            width: 100%;
            color: White;
        }
        .special{
            border: 2px solid #C35817;
        }
        .portlet-content{
            padding: 0.1em;
        }
        .ui-sortable-placeholder{
            border:0px;
            background:#FCDFFF;
            visibility: visible !important;
            height: 180px !important;
        }
        .ui-sortable-placeholder *{
            visibility: hidden;
        }
        .ui-icon ui-icon-plusthick{
            cursor:pointer;
        }
    </style>
    <script type="text/javascript">
        var layout="";
        var arrs_global=new Array();
        $(document).ready(function(){
            $.ajax({
                url: 'order_show.php',
                type:'POST',
                data:{
                    type:'1'
                },
                error:
                    function(xhr) {alert('Ajax request 發生錯誤');},
                success:
                    function(str){
                        dispatch(str);
                        initial();
                    }
                });
        })

        function initial(){
            var arrColumn=layout.split('|');
            $.each(arrColumn,function(m,n){
                var elemId=n.split(':')[0];
                var arrRow=n.split(':')[1]?n.split(':')[1].split('@'):"";
                $.each(arrRow, function(m,n){
                    if (n){
                        $("#" + elemId).append($("#sb" + n).attr('id', n))
                    }
                });
            })
            $(".column").sortable({
                connectWith:'.column',
                stop: saveLayout
            });

            function saveLayout() {
                var list = "";
                $.each($(".column"),function(m){
                    list+=$(this).attr('id')+":";
                    $.each($(this).children(".portlet"),function(d){
                        list += $(this).attr('id') + "@";
                    })
                    list += "|";
                })
                $.cookie("list", list);
            }
        }

        function transfer(){
                var args=$.cookie("list").split('|')[0].split(':')[1].split('@');
				//alert(args);
                var string="";
                for(var index in args)
                    if(args[index]!="")
                        string=string+arrs_global[args[index]]+"@";
                string=string.substr(0,(string.length-1));
				if(string!='undefined' && string!=""){
					$.ajax({
					url: 'check_product_num.php',
					type:'POST',
					data:{
						type: '1',
						str: string
					},
					error:
						function(xhr) {alert('Ajax request 發生錯誤');},
					success:
						function(str){
							if(str!=""){
								str=str.replace("^","\n");
								alert(str.(str == null));
							}
							else
								window.location.href="bidding.html?"+escape(string);
						}
					});
				}
        }
        var dispatch=function(str){
            var str_1="c1:";
            var str_2="c2:";
            var str_3="c3:";
            var arrs=str.split(';');
            for(var index in arrs){
                if(arrs[index]!=""){
                    var content=arrs[index].split(",");
                    integer=parseInt(index)+1;
                    arrs_global[integer]=content[0]+"|"+content[1]+"|"+content[2]+"|"+content[3]+"|"+content[4]+"|"+content[5]+"|"+content[7]+"|"+0;
                    $("#main").append("<div class='portlet' id='sb"+integer+"'><div class='portlet-header font_size'>"+content[0]+"</div><div class='portlet-content font_size_sm'>"+content[1]+"</div><div class='portlet-content font_size_sm'>"+content[2]+"</div><div class='portlet-content font_size_sm'>"+content[3]+"</div><div class='portlet-content font_size_sm'>"+content[4]+"</div><div class='portlet-content font_size_sm'>"+content[5]+"</div><div class='portlet-content font_size_sm'>"+content[6]+"</div></div>");
                    if(index%3==0)
                        str_1+=""+integer+"@";
                    else if(index%3==1)
                        str_2+=""+integer+"@";
                    else if(index%3==2)
                        str_3+=""+integer+"@";
                }
            }
            layout="c0|"+str_1.substr(0,(str_1.length)-1)+"|"+str_2.substr(0,(str_2.length)-1)+"|"+str_3.substr(0,(str_3.length)-1);
			$.cookie("list", layout);
        }
    </script>
<?php
	$content = <<<STRING
    	<body>
            <div>
                <div  id="main" style="display: none;">
                </div>
                <fieldset class="column special" id="c0">
                    <legend>已選擇訂單</legend>
                    <input type="image" src="../images/submit.png" onclick="javascript:transfer();"></input>
                </fieldset>
                <div class="column" id='c1'>
                </div>
                <div class="column" id='c2'>
                </div>
                <div class="column" id='c3'>
                </div>
            </div>
		</body>
STRING;
	echo $content;
?>
