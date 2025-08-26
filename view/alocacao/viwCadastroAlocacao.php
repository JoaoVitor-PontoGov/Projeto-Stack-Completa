<?php
@header("Content-Type: text/html; charset=ISO-8859-1", true);
?>

<script>
  $(function(){
     //--------------------------------------------------------------------------------------------------------------------//
    // Instanciando os campos da tela de cadastro
    //--------------------------------------------------------------------------------------------------------------------//
    $("#frmCadastroAlocacao #dtInicio").kendoDatePicker();

    $("#frmCadastroAlocacao #dtDevolucao").kendoDatePicker();
    //--------------------------------------------------------------------------------------------------------------------/

		$("#frmCadastroAlocacao #BtnEquipamento").kendoButton({
			spriteCssClass: "k-pg-icon k-i-l1-c2",
			enable: <?=$blEquipamentoInformado ? "false" : "true" ?>,
			click: function(){
				OpenWindow(true, "ConsultaEquipamento", "controller/equipamento/ctrEquipamento.php?action=winConsulta", "Consulta Equipamento","frmCadastroAlocacao");
			}
		});

		$("#frmCadastroAlocacao #BtnColaborador").kendoButton({
			spriteCssClass: "k-pg-icon k-i-l1-c2",
			click: function(){
				OpenWindow(true, "ConsultaColaborador", "controller/colaborador/ctrColaborador.php?action=winConsulta", "Consulta Colaborador","frmCadastroAlocacao");
			}
		});

		$("#frmCadastroAlocacao #nmEquipamento").kendoAutoComplete({
			dataTextField: "nmequipamento",
			minLength: 2,
			dataSource:{
				serverFiltering: true,
				transport: {
					read: {
						url: "controller/equipamento/ctrEquipamento.php",
						typr: "get",
						dataType: "json",
						data: {
							action: 'AutoComplete'
						}
					}
				},
				schema: {
					data: "data",
					model:{
						fields:{
							idequipamento: {field: "idequipamento", type: "number"},
							nmequipamento: {field: "nmequipamento", type: "string"}
						}
					}
				}
			},
			select: function(e){
				$("#frmCadastroAlocacao #idEquipamento").val(this.dataItem(e.item.index()).idequipamento);
			},
			filtering: function(e){
				$("#frmCadastroAlocacao #idEquipamento").val('');
			}
		});

		$("#frmCadastroAlocacao #nmColaborador").kendoAutoComplete({
			dataTextField: "nmcolaborador",
			minLength: 2,
			dataSource:{
				serverFiltering: true,
				transport: {
					read: {
						url: "controller/colaborador/ctrColaborador.php",
						typr: "get",
						dataType: "json",
						data: {
							action: 'AutoComplete'
						}
					}
				},
				schema: {
					data: "data",
					model:{
						fields:{
							idcolaboradorequipamento: {field: "idcolaboradorequipamento", type: "number"},
							nmcolaborador: {field: "nmcolaborador", type: "string"}
						}
					}
				}
			},
			select: function(e){
				$("#frmCadastroAlocacao #idColaborador").val(this.dataItem(e.item.index()).idcolaboradorequipamento);
			},
			filtering: function(e){
				$("#frmCadastroAlocacao #idColaborador").val('');
			}
		});

    //--------------------------------------------------------------------------------------------------------------------//
    // Barra de ações
    //--------------------------------------------------------------------------------------------------------------------//
    $("#frmCadastroAlocacao #BarAcoes").kendoToolBar({
			items: [
				{ type: "spacer" },
				{
					type: "buttonGroup", buttons: [
						{
							id: "BtnGravar",
							spriteCssClass: "k-pg-icon k-i-l1-c5",
							text: "Gravar",
							group: "actions",
							attributes: { tabindex: "30" },
							click: function () {
								$.post(
									"controller/alocacao/ctrAlocacao.php?action=gravar",
									$("#frmCadastroAlocacao").serialize(),
									function(response){
										Message(response.flDisplay, response.flTipo, response.dsMsg)

										if(response.flTipo == "S"){
											$("#frmConsultaAlocacao #BtnPesquisar").click();

											if(!<?=$blEquipamentoInformado ? "true" : "false" ?>){
												$("#frmCadastroAlocacao #BtnLimpar").click();
											} else {
												$("#WinCadastroAlocacao").data("kendoWindow").close();
											}
											
										}
									},"json"
								)
							}
						},
						{
							id: "BtnLimpar",
							spriteCssClass: "k-pg-icon k-i-l1-c6",
							text: "Limpar",
							group: "actions",
							attributes: { tabindex: "31" },
							click: function () {
								$("#WinCadastroAlocacao").data("kendoWindow").refresh(
									{
									url: "controller/alocacao/ctrAlocacao.php?action=incluir"
									});
							}
						},
						{
							id: "BtnExcluir",
							spriteCssClass: "k-pg-icon k-i-l1-c7",
							text: "Excluir",
							group: "actions",
							attributes: { tabindex: "32" },
							enable: false,
							click: function () {
								$.post(
									"controller/alocacao/ctrAlocacao.php?action=excluir",
									$("#frmCadastroAlocacao").serialize(),
									function(response){
										Message(response.flDisplay, response.flTipo, response.dsMsg);

										if(response.flTipo == "S"){
											$("#frmConsultaAlocacao #BtnPesquisar").click();
											$("#frmCadastroAlocacao #BtnLimpar").click();
										}
									},"json"
								)
							}
						},
						{
							id: "BtnFechar",
							spriteCssClass: "k-pg-icon k-i-l1-c4",
							text: "Fechar",
							group: "actions",
							attributes: { tabindex: "33" },
							click: function () {
								$("#WinCadastroAlocacao").data("kendoWindow").close();
							}
						}
					]
				}
			]
		})
    //--------------------------------------------------------------------------------------------------------------------//

    //--------------------------------------------------------------------------------------------------------------------//
    //  Ações diversas da tela de cadastro
    //--------------------------------------------------------------------------------------------------------------------//
    if($("#frmCadastroAlocacao #idAlocacao").val()!=""){
			$("#frmCadastroAlocacao #BarAcoes").data("kendoToolBar").enable("#BtnExcluir")
		}
		$("#WinCadastroAlocacao").data("kendoWindow").center().open();
    //--------------------------------------------------------------------------------------------------------------------//
  })
</script>

<div class="k-form">
	<form id="frmCadastroAlocacao">
		<table width="100%" cellspacing="2" cellpadding="0" role="presentation">
			<tr>
				<td style="text-align: right; width: 120px;">Id:</td>
				<td>
					<input type="text" id="idAlocacao" name="idAlocacao" class="k-textbox k-input-disabled"
						readonly="readonly" style="width: 80px;" tabindex="-1" value="<?php echo $objTbAlocacao->Get("idalocacao") ?>">
				</td>
			</tr>
		</table>
    <table width="100%" cellspacing="2" cellpadding="0" role="presentation">
			<tr>
				<td class="k-required" style="text-align: right; width: 120px;">Equipamento:</td>
				<td>
					<input type="text" id="idEquipamento" name="idEquipamento" class="k-textbox k-input-disabled"
						readonly="readonly" style="width: 60px;" tabindex="-1" value="<?php echo $objTbAlocacao->GetObjTbEquipamento()->Get("idequipamento") ?>">
					<span id="BtnEquipamento" style="cursor: pointer; height: 24px width: 24px;" title="Consultar colaborador"></span>
					<input tabindex="1" type="text" id="nmEquipamento" name="nmEquipamento" style="width: 511px;"
					 value="<?php echo $objTbAlocacao->GetObjTbEquipamento()->Get("nmequipamento")?>" <?php echo $blEquipamentoInformado ? "readonly='true'" : "" ?> <?php echo $blEquipamentoInformado ? "class='k-textbox k-input-disabled'" : "class='k-textbox'" ?>>
				</td>
			</tr>
		</table>
    <table width="100%" cellspacing="2" cellpadding="0" role="presentation">
			<tr>
				<td class="k-required" style="text-align: right; width: 120px;">Colaborador:</td>
				<td>
					<input type="text" id="idColaborador" name="idColaborador" class="k-textbox k-input-disabled"
						readonly="readonly" style="width: 60px;" tabindex="-1" value="<?php echo $objTbAlocacao->GetObjTbColaborador()->Get("idcolaboradorequipamento") ?>">
						<span id="BtnColaborador" style="cursor: pointer; height: 24px width: 24px;" title="Consultar colaborador"></span>
						<input tabindex="2" type="text" id="nmColaborador" name="nmColaborador" class="k-textbox" style="width: 511px;"
					 value="<?php echo $objTbAlocacao->GetObjTbColaborador()->Get("nmcolaborador")?>">
				</td>
			</tr>
		</table>
		<table width="100%" cellspacing="2" cellpadding="0" role="presentation">
			<tr>
				<td class="k-required" style="text-align: right; width: 120px;">Data de inicio:</td>
				<td>
					<input tabindex="3" id="dtInicio" name="dtInicio" style="width: 100px;"
					value="<?php echo $fmt->data($objTbAlocacao->Get("dtinicio"))?>">
				</td>
				<td style="text-align: right; width: 333px;">Data de devolucao:</td>
				<td>
					<input tabindex="3" id="dtDevolucao" name="dtDevolucao" style="width: 100px;"
					value="<?php echo $fmt->data($objTbAlocacao->Get("dtdevolucao"))?>">
				</td>
			</tr>
		</table>

		<div id="BarAcoes"></div>

	</form>
</div>