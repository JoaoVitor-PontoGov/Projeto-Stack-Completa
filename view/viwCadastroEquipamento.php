<script>
  $(function(){

    //--------------------------------------------------------------------------------------------------------------------//
    // Instanciando os campos da tela de cadastro
    //--------------------------------------------------------------------------------------------------------------------//
    $("#nrSerie").kendoNumericTextBox({
			min: '0',
			format: "0",
			decimals: 0,
		})

    $("#dtAquisicao").kendoDatePicker();

    $("#flStatus").kendoDropDownList({})
    //--------------------------------------------------------------------------------------------------------------------//

    //--------------------------------------------------------------------------------------------------------------------//
    // Barra de ações
    //--------------------------------------------------------------------------------------------------------------------//
    $("#frmCadastroEquipamento #BarAcoes").kendoToolBar({
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
									"controller/ctrEquipamento.php?action=gravar",
									$("#frmCadastroEquipamento").serialize(),
									function(response){
										Message(response.flDisplay, response.flTipo, response.dsMsg)
									},"json"
								)
							}
						},
						{
							id: "BtnFechar",
							spriteCssClass: "k-pg-icon k-i-l1-c4",
							text: "Fechar",
							group: "actions",
							attributes: { tabindex: "31" },
							click: function () {
								$("#WinCadastroEquipamento").data("kendoWindow").close();
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
    $("#WinCadastroEquipamento").data("kendoWindow").center().open();
    //--------------------------------------------------------------------------------------------------------------------//
  })
</script>

<div class="k-form">
	<form id="frmCadastroEquipamento">
		<table width="100%" cellspacing="2" cellpadding="0" role="presentation">
			<tr>
				<td style="text-align: right; width: 120px;">Id:</td>
				<td>
					<input type="text" id="idEquipamento" name="idEquipamento" class="k-textbox k-input-disabled"
						readonly="readonly" style="width: 80px;" value="<?php echo $objTbEquipamento->Get("idequipamento") ?>">
				</td>
			</tr>
		</table>
		<table width="100%" cellspacing="2" cellpadding="0" role="presentation">
			<tr>
				<td style="text-align: right; width: 120px;">Nome:</td>
				<td>
					<input type="text" id="nmEquipamento" name="nmEquipamento" class="k-textbox" style="width: 600px;"
					 value="<?php echo $objTbEquipamento->Get("nmequipamento")?>">
				</td>
			</tr>
		</table>
		<table width="100%" cellspacing="2" cellpadding="0" role="presentation">
			<tr>
				<td style="text-align: right; width: 120px;">Tipo:</td>
				<td>
					<input type="text" id="dsTipo" name="dsTipo" class="k-textbox" style="width: 600px;"
					value="<?php echo $objTbEquipamento->Get("dstipo")?>">
				</td>
			</tr>
		</table>
		<table width="100%" cellspacing="2" cellpadding="0" role="presentation">
			<tr>
				<td style="text-align: right; width: 120px;">Num Serie:</td>
				<td>
					<input id="nrSerie" name="nrSerie" style="width: 150px;"
					value="<?php echo $objTbEquipamento->Get("nrserie")?>">
				</td>
			</tr>
		</table>
		<table width="100%" cellspacing="2" cellpadding="0" role="presentation">
			<tr>
				<td style="text-align: right; width: 120px;">Data de aquisicao:</td>
				<td>
					<input id="dtAquisicao" name="dtAquisicao" style="width: 250px;"
					value="<?php echo $objTbEquipamento->Get("dtaquisicao")?>">
				</td>
			</tr>
		</table>
		<table width="100%" cellspacing="2" cellpadding="0" role="presentation">
			<tr>
				<td style="text-align: right; width: 120px;">Status:</td>
				<td>
					<select id="flStatus" name="flStatus" style="width: 250px;">
						<option></option>
						<option value="DP" <?php echo $objTbEquipamento->Get("flstatus")=="DP" ? "selected": "" ?>>Disponivel</option>
						<option value="EU" <?php echo $objTbEquipamento->Get("flstatus")=="EU" ? "selected": "" ?>>Em Uso</option>
						<option value="EM" <?php echo $objTbEquipamento->Get("flstatus")=="EM" ? "selected": "" ?>>Em Manutencao</option>
					</select>
				</td>
			</tr>
		</table>

		<div id="BarAcoes"></div>

	</form>
</div>