<?php
@header("Content-Type: text/html; charset=ISO-8859-1", true);
?>

<script>
  $(function(){

    //--------------------------------------------------------------------------------------------------------------------//
    // Barra de ações
    //--------------------------------------------------------------------------------------------------------------------//
    $("#frmCadastroColaborador #BarAcoes").kendoToolBar({
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
									"controller/colaborador/ctrColaborador.php?action=gravar",
									$("#frmCadastroColaborador").serialize(),
									function(response){
										Message(response.flDisplay, response.flTipo, response.dsMsg)

										if(response.flTipo == "S"){
											$("#frmConsultaColaborador #BtnPesquisar").click();
											$("#frmCadastroColaborador #BtnLimpar").click();
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
								$("#WinCadastroColaborador").data("kendoWindow").refresh(
									{
									url: "controller/colaborador/ctrColaborador.php?action=incluir"
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
									"controller/colaborador/ctrColaborador.php?action=excluir",
									$("#frmCadastroColaborador").serialize(),
									function(response){
										Message(response.flDisplay, response.flTipo, response.dsMsg);

										if(response.flTipo == "S"){
											$("#frmConsultaColaborador #BtnPesquisar").click();
											$("#frmCadastroColaborador #BtnLimpar").click();
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
								$("#WinCadastroColaborador").data("kendoWindow").close();
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
    if($("#frmCadastroColaborador #idColaborador").val()!=""){
			$("#frmCadastroColaborador #BarAcoes").data("kendoToolBar").enable("#BtnExcluir")
		}
		$("#WinCadastroColaborador").data("kendoWindow").center().open();
    //--------------------------------------------------------------------------------------------------------------------//
  })
</script>

<div class="k-form">
	<form id="frmCadastroColaborador">
		<table width="100%" cellspacing="2" cellpadding="0" role="presentation">
			<tr>
				<td style="text-align: right; width: 120px;">Id:</td>
				<td>
					<input type="text" id="idColaborador" name="idColaborador" class="k-textbox k-input-disabled"
						readonly="readonly" style="width: 80px;" tabindex="-1" value="<?php echo $objTbColaborador->Get("idcolaboradorequipamento") ?>">
				</td>
			</tr>
		</table>
		<table width="100%" cellspacing="2" cellpadding="0" role="presentation">
			<tr>
				<td class="k-required" style="text-align: right; width: 120px;">Nome:</td>
				<td>
					<input tabindex="1" type="text" id="nmColaborador" name="nmColaborador" class="k-textbox" style="width: 600px;"
					 value="<?php echo $objTbColaborador->Get("nmcolaborador")?>">
				</td>
			</tr>
		</table>
		<table width="100%" cellspacing="2" cellpadding="0" role="presentation">
			<tr>
				<td class="k-required" style="text-align: right; width: 120px;">E-mail:</td>
				<td>
					<input tabindex="2" type="text" id="dsEmail" name="dsEmail" class="k-textbox" style="width: 600px;"
					 value="<?php echo $objTbColaborador->Get("dsemail")?>">
				</td>
			</tr>
		</table>
    <table width="100%" cellspacing="2" cellpadding="0" role="presentation">
			<tr>
				<td class="k-required" style="text-align: right; width: 120px;">Setor:</td>
				<td>
					<input tabindex="3" type="text" id="dsSetor" name="dsSetor" class="k-textbox" style="width: 600px;"
					 value="<?php echo $objTbColaborador->Get("dssetor")?>">
				</td>
			</tr>
		</table>
    <table width="100%" cellspacing="2" cellpadding="0" role="presentation">
			<tr>
				<td class="k-required" style="text-align: right; width: 120px;">Cargo:</td>
				<td>
					<input tabindex="4" type="text" id="dsCargo" name="dsCargo" class="k-textbox" style="width: 600px;"
					 value="<?php echo $objTbColaborador->Get("dscargo")?>">
				</td>
			</tr>
		</table>

		<div id="BarAcoes"></div>

	</form>
</div>