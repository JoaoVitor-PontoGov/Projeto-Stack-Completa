<?php
@header("Content-Type: text/html; charset=ISO-8859-1", true);
?>

<script>
	$(function () {

		var arrDataSource = [
			{
				name: "idequipamento",
				type: "integer",
				label: "Id",
				visibleFilter: 'true',
				orderFilter: '2',

				orderGrid: '1',
				widthGrid: '70',
				hiddenGrid: 'false',
				headerAttributesGrid: 'text-align: center',
				atttibutesGrid: 'text-align: center',

				showPreview: 'true',
				indiceTabPreview: 'tabDadosGerais',
				widthPreview: '80',
				positionPreview: '1',
			},
			{
				name: "nmequipamento",
				type: "string",
				label: "Nome",
				visibleFilter: 'true',
				orderFilter: '3',

				orderGrid: '2',
				widthGrid: '300',
				hiddenGrid: 'false',
				headerAttributesGrid: 'text-align: center',
				atttibutesGrid: 'text-align: center',

				showPreview: 'true',
				indiceTabPreview: 'tabDadosGerais',
				widthPreview: '400',
				positionPreview: '2',
			},
			{
				name: "dstipo",
				type: "string",
				label: "Tipo",
				visibleFilter: 'true',
				orderFilter: '4',

				orderGrid: '3',
				widthGrid: '300',
				hiddenGrid: 'false',
				headerAttributesGrid: 'text-align: center',
				atttibutesGrid: 'text-align: center',

				showPreview: 'true',
				indiceTabPreview: 'tabDadosGerais',
				widthPreview: '400',
				positionPreview: '3',
			},
			{
				name: "nrserie",
				type: "integer",
				label: "Num serie",
				visibleFilter: 'true',
				orderFilter: '5',

				orderGrid: '4',
				widthGrid: '150',
				hiddenGrid: 'false',
				headerAttributesGrid: 'text-align: center',
				attributesGrid: 'text-align: center',

				showPreview: 'true',
				indiceTabPreview: 'tabDadosGerais',
				widthPreview: '80',
				positionPreview: '4'
			},
			{
				name: "dtaquisicao",
				type: "date",
				label: "Data de aquisicao",
				visibleFilter: 'true',
				orderFilter: '6',

				orderGrid: '5',
				widthGrid: '150',
				hiddenGrid: 'false',
				headerAttributesGrid: "text-align: center",
				attributesGrid: 'text-align: center',

				showPreview: 'true',
				indiceTabPreview: 'tabDadosGerais',
				widthPreview: '150',
				positionPreview: '5'
			},
			{
				name: "flstatus",
				type: "string",
				label: "Status",
				visibleFilter: 'true',
				orderFilter: '7',

				orderGrid: '6',
				widthGrid: '200',
				hiddenGrid: 'false',
				headerAttributesGrid: "text-align: center",
				attributesGrid: 'text-align: center',

				showPreview: 'true',
				indiceTabPreview: 'tabDadosGerais',
				widthPreview: '200',
				positionPreview: '6'
			},
		]

		//--------------------------------------------------------------------------------------------------------------------//
		// Configura a tela para usar spliter
		//--------------------------------------------------------------------------------------------------------------------//
		arrDataSource = LoadConfigurationQuery(arrDataSource, "ConsultaEquipamento");
		//--------------------------------------------------------------------------------------------------------------------//

		//--------------------------------------------------------------------------------------------------------------------//
		// Instanciando os campos combo da pesquisa
		//--------------------------------------------------------------------------------------------------------------------//
		createPgFilter(arrDataSource, "ConsultaEquipamento");
		//--------------------------------------------------------------------------------------------------------------------//

		//--------------------------------------------------------------------------------------------------------------------//
		// Área de botões de ações
		//--------------------------------------------------------------------------------------------------------------------//
		$("#frmConsultaEquipamento #BarAcoes").kendoToolBar({
			items: [
				{
					type: "spacer"
				},
				{
					type: "buttonGroup", buttons:[
						
						{
							id:"BtnAlocar",
							spriteCssClass: "k-pg-icon k-i-l3-c5",
							text: "Alocar",
							group: "actions",
							enable: false,
							attributes: { tabindex: "28" },
							click: function () {
								var GrdConsultaEquipamento = $("#frmConsultaEquipamento #GrdConsultaEquipamento").data("kendoGrid");
								var RstEquipamento = GrdConsultaEquipamento.dataItem(GrdConsultaEquipamento.select());
								console.log(RstEquipamento)

								OpenWindow(true, "CadastroAlocacao", "controller/alocacao/ctrAlocacao.php?action=incluir&idEquipamento=" + RstEquipamento.idequipamento, "Cadastro Alocacao")
							}
						},
						{
							id:"BtnSelecionar",
							spriteCssClass: "k-pg-icon k-i-l9-c4",
							text: "Selecionar",
							group: "actions",
							enable: false,
							attributes: { tabindex: "29" },
							click: function () {
								var GrdConsultaEquipamento = $("#frmConsultaEquipamento #GrdConsultaEquipamento").data("kendoGrid");
								var RstEquipamento = GrdConsultaEquipamento.dataItem(GrdConsultaEquipamento.select());

								$("<?=$frmResult?> #idEquipamento").val(RstEquipamento.idequipamento).change();
								$("<?=$frmResult?> #nmEquipamento").val(RstEquipamento.nmequipamento).change();

								$("#WinConsultaEquipamento").data("kendoWindow").close();
							}
						}
					]
				},
				{
					type: "buttonGroup", buttons: [
						{
							id: "BtnIncluir",
							spriteCssClass: "k-pg-icon k-i-l1-c1",
							text: "Incluir",
							group: "actions",
							attributes: { tabindex: "30" },
							click: function () {
								console.log("!")
								OpenWindow(true, "CadastroEquipamento", "controller/equipamento/ctrEquipamento.php?action=incluir", "Cadastro Equipamento")
							}
						},
						{
							id: "BtnEditar",
							spriteCssClass: "k-pg-icon k-i-l1-c3",
							text: "Editar",
							group: "actions",
							attributes: { tabindex: "31" },
							enable: false,
							click: function () {
								var grid = $("#frmConsultaEquipamento #GrdConsultaEquipamento").data("kendoGrid")
								var campoSelecionado = grid.dataItem(grid.select())


								OpenWindow(true, "CadastroEquipamento", "controller/equipamento/ctrEquipamento.php?action=editar&idEquipamento="+campoSelecionado.idequipamento, "Cadastro Equipamento")
							}
						},
						{
							id: "BtnFechar",
							spriteCssClass: "k-pg-icon k-i-l1-c4",
							text: "Fechar",
							group: "actions",
							attributes: { tabindex: "32" },
							click: function () {
								$("#WinConsultaEquipamento").data("kendoWindow").close();
							}
						}
					]
				}
			]
		})
		//--------------------------------------------------------------------------------------------------------------------//

		//--------------------------------------------------------------------------------------------------------------------//
		// Instanciando o data source da consulta
		//--------------------------------------------------------------------------------------------------------------------//
		let DtsConsultaEquipamento = new kendo.data.DataSource({
			pageSize: 100,
			serverPaging: true,
			serverFiltering: true,
			serverSorting: true,
			transport: {
				read: {
					url: "controller/equipamento/ctrEquipamento.php",
					type: "GET",
					dataType: "json",
					data: function(){
						return {
							action: "ListEquipamento",
							filters: getExtraFilter()
						}
					}
				}
			},
			schema: {
				data: "jsnEquipamento",
				total: "jsnTotal",
				model: {
					fields: getModelDataSource(arrDataSource),
				},
				errors: "error",

			}
		})
		//--------------------------------------------------------------------------------------------------------------------//

		//--------------------------------------------------------------------------------------------------------------------//
		// Instanciando o botão de consulta
		//--------------------------------------------------------------------------------------------------------------------//
		$("#frmConsultaEquipamento #BtnPesquisar").kendoButton({
			click: function () {
				DtsConsultaEquipamento.filter(getExtraFilter())
				DtsConsultaEquipamento.read()
			}
		})
		//--------------------------------------------------------------------------------------------------------------------//

		//--------------------------------------------------------------------------------------------------------------------//
		// Filto extra de consulta
		//--------------------------------------------------------------------------------------------------------------------//
		function getExtraFilter() {
			let arrFilds = LoadFilterSplitter("ConsultaEquipamento", arrDataSource)
			return arrFilds;
		}
		//--------------------------------------------------------------------------------------------------------------------//

		//--------------------------------------------------------------------------------------------------------------------//
		// Instanciando o grid da consulta
		//--------------------------------------------------------------------------------------------------------------------//
		$("#frmConsultaEquipamento #GrdConsultaEquipamento").kendoGrid({
			pdf: SetPdfOptions("Listagem de equipamentos"),
			pdfExport: function () {
				tituloPdfExport = "Listagem de equipamentos"
			},
			dataSource: DtsConsultaEquipamento,
			height: getHeightGridQuery("ConsultaEquipamento"),
			columns: getColumnsQuery(arrDataSource),
			selectable: "row",
			resizable: true,
			reordenable: true,
			navigatable: true,
			columnMenu: true,
			filterable: true,
			sortable: {
				mode: "multiple",
				allowUnsort: true,
			},
			pageable: {
				pageSizes: [100, 300, 500, "all"],
				numeric: false,
				input: true
			},
			columnShow: function (e) { setWidthOnShowColumnGrid(e, 'ConsultaEquipamento'); },
			columnHide: function (e) { setWidthOnHideColumnGrid(e, 'ConsultaEquipamento'); },
			filter: function (e) { mountFilteredScreen('filterColumn', e, 'ConsultaEquipamento', arrDataSource, DtsConsultaEquipamento, getExtraFilter()); },
			change: function () {
				$("#frmConsultaEquipamento #BarAcoes").data("kendoToolBar").enable("#BtnEditar")
				$("#frmConsultaEquipamento #BarAcoes").data("kendoToolBar").enable("#BtnAlocar")
				if("<?=$frmResult?>" != ""){
					$("#frmConsultaEquipamento #BarAcoes").data("kendoToolBar").enable("#BtnSelecionar")
				}
			},
			dataBound: function () {
				LoadGridExportActions("frmConsultaEquipamento", "GrdConsultaEquipamento", true)
			}
		})

		$("#frmConsultaEquipamento #GrdConsultaEquipamento").on("dblclick", "tbody>tr", function(){
			if("<?=$frmResult?>" != ""){
				$("#frmConsultaEquipamento #BtnSelecionar").click();
			} else {
				$("#frmConsultaEquipamento #BtnEditar").click();
			}
		})
		//--------------------------------------------------------------------------------------------------------------------//

		//--------------------------------------------------------------------------------------------------------------------//
		//	Ação para abrir a tela de consulta
		//--------------------------------------------------------------------------------------------------------------------//
		$("#WinConsultaEquipamento").data("kendoWindow").open();
		//--------------------------------------------------------------------------------------------------------------------//

		//--------------------------------------------------------------------------------------------------------------------//
		// Cria a tela de vizualização do item do grid na consulta, e faz outras coisa aí...
		//--------------------------------------------------------------------------------------------------------------------//
		createScreenPreview(arrDataSource, "ConsultaEquipamento");
		//--------------------------------------------------------------------------------------------------------------------//
	})
</script>

<div class="k-form">
	<form id="frmConsultaEquipamento">
		<div id="splConsulta">
			<div id="splHeader">
				<div class="k-bg-blue screen-filter-content">
					
					<table>
						<tr>
							<td style="width: 120px;text-align: right;vertical-align: top;padding-top: 6px;">
								Filtro(s):
							</td>

							<td>
								<div id="fltConsultaEquipamento" style="width: auto;"></div>
							</td>

							<td style="vertical-align: bottom;padding-bottom: 5px;">
								<span id="BtnPesquisar" style="cursor: pointer;width: 100px;height: 24px;"
									title="Pesquisar" data-role="button" class="k-button k-button-icon" role="button"
									aria-disabled="false" tabindex="29">
									<span class="k-sprite k-pg-icon k-i-l1-c2"
										style="margin: 0 auto; text-align: center;"></span>
									<span style="margin: 0 auto; margin-right: 3px;">Pesquisar</span>
								</span>

								<span id="BtnAddFilter"
									style="cursor: pointer;width: 21px !important;height: 21px !important"
									title="Adicionar Filtro" data-role="button" class="k-button k-button-icon"
									role="button" aria-disabled="false" tabindex="">
									<span class="k-sprite k-pg-icon k-i-l1-c1"
										style="margin: 0 auto;margin-top: 1.4px;"></span>
								</span>
							</td>
						</tr>
					</table>

					<div id="BarAcoes" style="text-align: right;height: 28px;"></div>
				</div>
			</div>
			<div id="splMiddle">
				<div id="GrdConsultaEquipamento" data-use-state-screen="true"></div>
			</div>
			<div id="splFooter">
				<div id="bottonConsultaEquipamento">
					<div id="tabStripConsultaEquipamento">
						<ul>
							<li id="tabDadosGerais" class="k-state-active"><label>Detalhes</label></li>
						</ul>
						<div id="tabDadosGeraisVisualizacaoConsultaEquipamento"></div>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>