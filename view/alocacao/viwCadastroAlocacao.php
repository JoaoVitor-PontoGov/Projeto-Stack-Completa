<?php
@header("Content-Type: text/html; charset=ISO-8859-1", true);
?>

<script>
  $(function(){
     //--------------------------------------------------------------------------------------------------------------------//
    // Instanciando os campos da tela de cadastro
    //--------------------------------------------------------------------------------------------------------------------//
    $("#dtInicio").kendoDatePicker();

    $("#dtDevolucao").kendoDatePicker();
    //--------------------------------------------------------------------------------------------------------------------//

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
											$("#frmCadastroAlocacao #BtnLimpar").click();
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
				<td style="text-align: right; width: 120px;">Id Equipamento:</td>
				<td>
					<input type="text" id="idEquipamento" name="idEquipamento" class="k-textbox k-input-disabled"
						readonly="readonly" style="width: 80px;" tabindex="-1" value="<?php echo $objTbAlocacao->GetObjTbEquipamento()->Get("idequipamento") ?>">
				</td>
			</tr>
		</table>
		<table width="100%" cellspacing="2" cellpadding="0" role="presentation">
			<tr>
				<td class="k-required" style="text-align: right; width: 120px;">Nome Equipamento:</td>
				<td>
					<input tabindex="1" type="text" id="nmEquipamento" name="nmEquipamento" class="k-textbox" style="width: 600px;"
					 value="<?php echo $objTbAlocacao->GetObjTbEquipamento()->Get("nmequipamento")?>">
				</td>
			</tr>
		</table>
    <table width="100%" cellspacing="2" cellpadding="0" role="presentation">
			<tr>
				<td style="text-align: right; width: 120px;">Id Colaborador:</td>
				<td>
					<input type="text" id="idColaborador" name="idColaborador" class="k-textbox k-input-disabled"
						readonly="readonly" style="width: 80px;" tabindex="-1" value="<?php echo $objTbAlocacao->GetObjTbColaborador()->Get("idcolaboradorequipamento") ?>">
				</td>
			</tr>
		</table>
		<table width="100%" cellspacing="2" cellpadding="0" role="presentation">
			<tr>
				<td class="k-required" style="text-align: right; width: 120px;">Nome Colaborador:</td>
				<td>
					<input tabindex="2" type="text" id="nmColaborador" name="nmColaborador" class="k-textbox" style="width: 600px;"
					 value="<?php echo $objTbAlocacao->GetObjTbColaborador()->Get("nmcolaborador")?>">
				</td>
			</tr>
		</table>
		<table width="100%" cellspacing="2" cellpadding="0" role="presentation">
			<tr>
				<td class="k-required" style="text-align: right; width: 120px;">Data de inicio:</td>
				<td>
					<input tabindex="3" id="dtInicio" name="dtInicio" style="width: 250px;"
					value="<?php echo $fmt->data($objTbAlocacao->Get("dtinicio"))?>">
				</td>
			</tr>
		</table>
    <table width="100%" cellspacing="2" cellpadding="0" role="presentation">
			<tr>
				<td class="k-required" style="text-align: right; width: 120px;">Data de devolucao:</td>
				<td>
					<input tabindex="3" id="dtDevolucao" name="dtDevolucao" style="width: 250px;"
					value="<?php echo $fmt->data($objTbAlocacao->Get("dtdevolucao"))?>">
				</td>
			</tr>
		</table>

		<div id="BarAcoes"></div>

	</form>
</div>