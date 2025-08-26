<?php
@header("Content-Type: text/html; charset=ISO-8859-1", true);
?>

<script>
	$(function(){

		var arrDataSource = [
			{
				name: "idalocacao",
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
				name: "idequipamento",
				type: "string",
				label: "Id Equipamento",
				visibleFilter: 'false',
				orderFilter: '3',

				orderGrid: '2',
				widthGrid: '70',
				hiddenGrid: 'false',
				headerAttributesGrid: 'text-align: center',
				atttibutesGrid: 'text-align: center',

				showPreview: 'true',
				indiceTabPreview: 'tabDadosGerais',
				widthPreview: '80',
				positionPreview: '2',
			},
			{
				name: "nmequipamento",
				type: "string",
				label: "Nome Equipamento",
				visibleFilter: 'false',
				orderFilter: '4',

				orderGrid: '3',
				widthGrid: '200',
				hiddenGrid: 'false',
				headerAttributesGrid: 'text-align: center',
				atttibutesGrid: 'text-align: center',

				showPreview: 'true',
				indiceTabPreview: 'tabDadosGerais',
				widthPreview: '400',
				positionPreview: '3',
			},
			{
				name: "idcolaboradorequipamento",
				type: "string",
				label: "Id Colaborador",
				visibleFilter: 'false',
				orderFilter: '5',

				orderGrid: '4',
				widthGrid: '70',
				hiddenGrid: 'false',
				headerAttributesGrid: 'text-align: center',
				atttibutesGrid: 'text-align: center',

				showPreview: 'true',
				indiceTabPreview: 'tabDadosGerais',
				widthPreview: '80',
				positionPreview: '4',
			},
			{
				name: "nmcolaborador",
				type: "string",
				label: "Nome Colaborador",
				visibleFilter: 'false',
				orderFilter: '6',

				orderGrid: '5',
				widthGrid: '300',
				hiddenGrid: 'false',
				headerAttributesGrid: 'text-align: center',
				atttibutesGrid: 'text-align: center',

				showPreview: 'true',
				indiceTabPreview: 'tabDadosGerais',
				widthPreview: '400',
				positionPreview: '5',
			},
			{
				name: "dtinicio",
				type: "date",
				label: "Data de inicio",
				visibleFilter: 'true',
				orderFilter: '7',

				orderGrid: '6',
				widthGrid: '150',
				hiddenGrid: 'false',
				headerAttributesGrid: 'text-align: center',
				attributesGrid: 'text-align: center',

				showPreview: 'true',
				indiceTabPreview: 'tabDadosGerais',
				widthPreview: '150',
				positionPreview: '6'
			},
			{
				name: "dtdevolucao",
				type: "date",
				label: "Data de devolucao",
				visibleFilter: 'true',
				orderFilter: '8',

				orderGrid: '7',
				widthGrid: '150',
				hiddenGrid: 'false',
				headerAttributesGrid: "text-align: center",
				attributesGrid: 'text-align: center',

				showPreview: 'true',
				indiceTabPreview: 'tabDadosGerais',
				widthPreview: '150',
				positionPreview: '7'
			}

		]	

		//--------------------------------------------------------------------------------------------------------------------//
		// Configura a tela para usar spliter
		//--------------------------------------------------------------------------------------------------------------------//
		arrDataSource = LoadConfigurationQuery(arrDataSource, "ConsultaAlocacao");
		//--------------------------------------------------------------------------------------------------------------------//

		$("#frmConsultaAlocacao #BtnEquipamento").kendoButton({
			spriteCssClass: "k-pg-icon k-i-l1-c2",
			click: function(){
				OpenWindow(true, "ConsultaEquipamento", "controller/equipamento/ctrEquipamento.php?action=winConsulta", "Consulta Equipamento","frmConsultaAlocacao");
			}
		});

		$("#frmConsultaAlocacao #BtnExcluirEquipamento").kendoButton({
			spriteCssClass: "k-pg-icon k-i-l1-c6",
			click: function(){
				$("#frmConsultaAlocacao #idEquipamento").val("");
				$("#frmConsultaAlocacao #nmEquipamento").val("");
			}
		});

		$("#frmConsultaAlocacao #BtnColaborador").kendoButton({
			spriteCssClass: "k-pg-icon k-i-l1-c2",
			click: function(){
				OpenWindow(true, "ConsultaColaborador", "controller/colaborador/ctrColaborador.php?action=winConsulta", "Consulta Colaborador","frmConsultaAlocacao");
			}
		});

		$("#frmConsultaAlocacao #BtnExcluirColaborador").kendoButton({
			spriteCssClass: "k-pg-icon k-i-l1-c6",
			click: function(){
				$("#frmConsultaAlocacao #idColaborador").val("");
				$("#frmConsultaAlocacao #nmColaborador").val("");
			}
		});

		//--------------------------------------------------------------------------------------------------------------------//
		// Instanciando os campos combo da pesquisa
		//--------------------------------------------------------------------------------------------------------------------//
		createPgFilter(arrDataSource, "ConsultaAlocacao");
		//--------------------------------------------------------------------------------------------------------------------//

		//--------------------------------------------------------------------------------------------------------------------//
		// Área de botões de ações
		//--------------------------------------------------------------------------------------------------------------------//
		$("#frmConsultaAlocacao #BarAcoes").kendoToolBar({
			items: [
				{
					type: "spacer"
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
								OpenWindow(true, "CadastroAlocacao", "controller/alocacao/ctrAlocacao.php?action=incluir", "Cadastro Alocacao")
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
								var grid = $("#frmConsultaAlocacao #GrdConsultaAlocacao").data("kendoGrid")
								var campoSelecionado = grid.dataItem(grid.select())


								OpenWindow(true, "CadastroAlocacao", "controller/alocacao/ctrAlocacao.php?action=editar&idAlocacao="+campoSelecionado.idalocacao, "Cadastro Alocacao")
							}
						},
						{
							id: "BtnFechar",
							spriteCssClass: "k-pg-icon k-i-l1-c4",
							text: "Fechar",
							group: "actions",
							attributes: { tabindex: "32" },
							click: function () {
								$("#WinConsultaAlocacao").data("kendoWindow").close();
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
		let DtsConsultaAlocacao = new kendo.data.DataSource({
			pageSize: 100,
			serverPaging: true,
			serverFiltering: true,
			serverSorting: true,
			transport: {
				read: {
					url: "controller/alocacao/ctrAlocacao.php",
					type: "GET",
					dataType: "json",
					data: function(){
						return {
							action: "ListAlocacao",
							filters: getExtraFilter()
						}
					}
				}
			},
			schema: {
				data: "jsnAlocacao",
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
		$("#frmConsultaAlocacao #BtnPesquisar").kendoButton({
			click: function () {
				DtsConsultaAlocacao.filter(getExtraFilter())
				DtsConsultaAlocacao.read()
			}
		})
		//--------------------------------------------------------------------------------------------------------------------//

		//--------------------------------------------------------------------------------------------------------------------//
		// Filto extra de consulta
		//--------------------------------------------------------------------------------------------------------------------//
		function getExtraFilter() {
			let arrFilds = LoadFilterSplitter("ConsultaAlocacao", arrDataSource)
			return arrFilds;
		}
		//--------------------------------------------------------------------------------------------------------------------//

		//--------------------------------------------------------------------------------------------------------------------//
		// Instanciando o grid da consulta
		//--------------------------------------------------------------------------------------------------------------------//
		$("#frmConsultaAlocacao #GrdConsultaAlocacao").kendoGrid({
			pdf: SetPdfOptions("Listagem de alocacao"),
			pdfExport: function () {
				tituloPdfExport = "Listagem de alocacao"
			},
			dataSource: DtsConsultaAlocacao,
			height: getHeightGridQuery("ConsultaAlocacao"),
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
			columnShow: function (e) { setWidthOnShowColumnGrid(e, 'ConsultaAlocacao'); },
			columnHide: function (e) { setWidthOnHideColumnGrid(e, 'ConsultaAlocacao'); },
			filter: function (e) { mountFilteredScreen('filterColumn', e, 'ConsultaAlocacao', arrDataSource, DtsConsultaAlocacao, getExtraFilter()); },
			change: function () {
				$("#frmConsultaAlocacao #BarAcoes").data("kendoToolBar").enable("#BtnEditar")
			},
			dataBound: function () {
				LoadGridExportActions("frmConsultaAlocacao", "GrdConsultaAlocacao", true)
			}
		})

		$("#frmConsultaAlocacao #GrdConsultaAlocacao").on("dblclick", "tbody>tr", function(){
			$("#frmConsultaAlocacao #BtnEditar").click();
		})
		//--------------------------------------------------------------------------------------------------------------------//

		//--------------------------------------------------------------------------------------------------------------------//
		//	Ação para abrir a tela de consulta
		//--------------------------------------------------------------------------------------------------------------------//
		$("#WinConsultaAlocacao").data("kendoWindow").open();
		//--------------------------------------------------------------------------------------------------------------------//

		//--------------------------------------------------------------------------------------------------------------------//
		// Cria a tela de vizualização do item do grid na consulta, e faz outras coisa aí...
		//--------------------------------------------------------------------------------------------------------------------//
		createScreenPreview(arrDataSource, "ConsultaAlocacao");
		//--------------------------------------------------------------------------------------------------------------------//
	})
</script>

<div class="k-form">
  <form id="frmConsultaAlocacao">
    <div id="splConsulta">
      <div id="splHeader">
        <div class="k-bg-blue screen-filter-content">
					<table width="100%" border="0" cellspacing="2" cellpading="0" role="presentation">
						<tr>
							<td style="width: 120px; text-align: right;">Equipamento:</td>
							<td style="padding-left: 3px;">
								<input type="text" tabindex="-1" name="idEquipamento" id="idEquipamento" class="k-input-disabled k-textbox" readonly="readonly" style="width: 60px; background-color: #e8e8e8;">
								<span tabindex="-1" id="BtnEquipamento" style="cursor: pointer; whidth: 24px; height: 24px;" title="Consultar Alocacoes..."></span>
								<input type="text" tabindex="-1" id="nmEquipamento" name="nmEquipamento" class="k-input-disabled k-textbox" readonly="readonly" style="width: 426px; background-color: #e8e8e8;">
								<span tabindex="-1" id="BtnExcluirEquipamento" style="cursor: pointer; width: 21px !important; height: 21px !important; margin-left: -1px !important;" title="Excluir Equipamento..."></span>
							</td>
						</tr>

						<tr>
							<td style="width: 120px; text-align: right;">Colaborador:</td>
							<td style="padding-left: 3px;">
								<input type="text" tabindex="-1" name="idColaborador" id="idColaborador" class="k-input-disabled k-textbox" readonly="readonly" style="width: 60px; background-color: #e8e8e8;">
								<span tabindex="-1" id="BtnColaborador" style="cursor: pointer; whidth: 24px; height: 24px;" title="Consultar Alocacoes..."></span>
								<input type="text" tabindex="-1" id="nmColaborador" name="nmColaborador" class="k-input-disabled k-textbox" readonly="readonly" style="width: 426px; background-color: #e8e8e8;">
								<span tabindex="-1" id="BtnExcluirColaborador" style="cursor: pointer; width: 21px !important; height: 21px !important; margin-left: -1px !important;" title="Excluir Colaborador..."></span>
							</td>
						</tr>
					</table>
          <table>
						<tr>
							<td style="width: 120px;text-align: right;vertical-align: top;padding-top: 6px;">
								Filtro(s):
							</td>

							<td>
								<div id="fltConsultaAlocacao" style="width: auto;"></div>
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
        <div id="GrdConsultaAlocacao" data-use-state-screen="true"></div>
      </div>
      <div id="splFooter">
        <div id="bottonConsultaAlocacao">
					<div id="tabStripConsultaAlocacao">
						<ul>
							<li id="tabDadosGerais" class="k-state-active"><label>Detalhes</label></li>
						</ul>
						<div id="tabDadosGeraisVisualizacaoConsultaAlocacao"></div>
					</div>
				</div>
      </div>
    </div>
  </form>
</div>