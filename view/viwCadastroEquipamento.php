<script>
  $(function(){
    

    kendo.culture("pt-BR");

    $("#nrSerie").kendoNumericTextBox({
			min: '0',
			format: "0",
			decimals: 0,
		})

    $("#dtAquisicao").kendoDatePicker();

    $("#flStatus").kendoDropDownList({
			optionLabel: "Informe o status..." ,
			dataSource: [
				{ name: "Disponivel" },
				{ name: "Em Uso" },
				{ name: "Em Manutencao" }
			],
      dataTextField: "name",
			dataValueField: "flStatus"
		})

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
    $("#WinCadastroEquipamento").data("kendoWindow").center().open();
  })
</script>

<div class="k-form">
	<form id="frmCadastroEquipamento">
		<table width="100%" cellspacing="2" cellpadding="0" role="presentation">
			<tr>
				<td style="text-align: right; width: 120px;">Id:</td>
				<td>
					<input type="text" id="idEquipamento" name="idEquipamento" class="k-textbox k-input-disabled"
						readonly="readonly" style="width: 80px;">
				</td>
			</tr>
		</table>
		<table width="100%" cellspacing="2" cellpadding="0" role="presentation">
			<tr>
				<td style="text-align: right; width: 120px;">Nome:</td>
				<td>
					<input type="text" id="nmEquipamento" name="nmEquipamento" class="k-textbox" style="width: 600px;">
				</td>
			</tr>
		</table>
		<table width="100%" cellspacing="2" cellpadding="0" role="presentation">
			<tr>
				<td style="text-align: right; width: 120px;">Tipo:</td>
				<td>
					<input type="text" id="dsTipo" name="dsTipo" class="k-textbox" style="width: 600px;">
				</td>
			</tr>
		</table>
		<table width="100%" cellspacing="2" cellpadding="0" role="presentation">
			<tr>
				<td style="text-align: right; width: 120px;">Num Serie:</td>
				<td>
					<input id="nrSerie" name="nrSerie" style="width: 150px;">
				</td>
			</tr>
		</table>
		<table width="100%" cellspacing="2" cellpadding="0" role="presentation">
			<tr>
				<td style="text-align: right; width: 120px;">Data de aquisicao:</td>
				<td>
					<input id="dtAquisicao" name="dtAquisicao" style="width: 250px;">
				</td>
			</tr>
		</table>
		<table width="100%" cellspacing="2" cellpadding="0" role="presentation">
			<tr>
				<td style="text-align: right; width: 120px;">Status:</td>
				<td>
					<input id="flStatus" name="flStatus" style="width: 250px;">
				</td>
			</tr>
		</table>

		<div id="BarAcoes"></div>

		<div id="popNotificacao">
			<ul></ul>
		</div>
	</form>
</div>