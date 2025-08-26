<?php
@header("Content-Type: text/html; charset=ISO-8859-1", true);
?>

<script>
  $(function(){

    var arrDataSource = [
      {
				name: "idcolaboradorequipamento",
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
				name: "nmcolaborador",
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
				name: "dsemail",
				type: "string",
				label: "Email",
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
				name: "dssetor",
				type: "string",
				label: "Setor",
				visibleFilter: 'true',
				orderFilter: '5',

				orderGrid: '4',
				widthGrid: '300',
				hiddenGrid: 'false',
				headerAttributesGrid: 'text-align: center',
				atttibutesGrid: 'text-align: center',

				showPreview: 'true',
				indiceTabPreview: 'tabDadosGerais',
				widthPreview: '400',
				positionPreview: '4',
			},
      {
				name: "dscargo",
				type: "string",
				label: "Cargo",
				visibleFilter: 'true',
				orderFilter: '6',

				orderGrid: '4',
				widthGrid: '300',
				hiddenGrid: 'false',
				headerAttributesGrid: 'text-align: center',
				atttibutesGrid: 'text-align: center',

				showPreview: 'true',
				indiceTabPreview: 'tabDadosGerais',
				widthPreview: '400',
				positionPreview: '4',
			}
    ]

    //--------------------------------------------------------------------------------------------------------------------//
		// Configura a tela para usar spliter
		//--------------------------------------------------------------------------------------------------------------------//
		arrDataSource = LoadConfigurationQuery(arrDataSource, "ConsultaColaborador");
		//--------------------------------------------------------------------------------------------------------------------//

    //--------------------------------------------------------------------------------------------------------------------//
		// Instanciando os campos combo da pesquisa
		//--------------------------------------------------------------------------------------------------------------------//
		createPgFilter(arrDataSource, "ConsultaColaborador");
		//--------------------------------------------------------------------------------------------------------------------//

    //--------------------------------------------------------------------------------------------------------------------//
		// Área de botões de ações
		//--------------------------------------------------------------------------------------------------------------------//
		$("#frmConsultaColaborador #BarAcoes").kendoToolBar({
			items: [
				{
					type: "spacer"
				},
				{
					type: "buttonGroup", buttons:[
						{
							id: "BtnAcessoRapido",
							spriteCssClass: "k-pg-icon k-i-l2-c10",
							text: "Acesso Rapido <span class='k-icon k-i-arrow-s' style='width:12px'></span>",
							group: "actions",
							enable: false,
							attributes: { tabindex: "27" },
						},
						{
							id:"BtnSelecionar",
							spriteCssClass: "k-pg-icon k-i-l9-c4",
							text: "Selecionar",
							group: "actions",
							enable: false,
							attributes: { tabindex: "29" },
							click: function () {
								var GrdConsultaColaborador = $("#frmConsultaColaborador #GrdConsultaColaborador").data("kendoGrid");
								var RstColaborador = GrdConsultaColaborador.dataItem(GrdConsultaColaborador.select());

								$("<?=$frmResult?> #idColaborador").val(RstColaborador.idcolaboradorequipamento).change();
								$("<?=$frmResult?> #nmColaborador").val(RstColaborador.nmcolaborador).change();

								$("#WinConsultaColaborador").data("kendoWindow").close();
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
								OpenWindow(true, "CadastroColaborador", "controller/colaborador/ctrColaborador.php?action=incluir", "Cadastro Colaborador")
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
								var grid = $("#frmConsultaColaborador #GrdConsultaColaborador").data("kendoGrid")
								var campoSelecionado = grid.dataItem(grid.select())


								OpenWindow(true, "CadastroColaborador", "controller/colaborador/ctrColaborador.php?action=editar&idColaborador="+campoSelecionado.idcolaboradorequipamento, "Cadastro Colaborador")
							}
						},
						{
							id: "BtnFechar",
							spriteCssClass: "k-pg-icon k-i-l1-c4",
							text: "Fechar",
							group: "actions",
							attributes: { tabindex: "32" },
							click: function () {
								$("#WinConsultaColaborador").data("kendoWindow").close();
							}
						}
					]
				}
			]
		})
		//--------------------------------------------------------------------------------------------------------------------//

		//--------------------------------------------------------------------------------------------------------------------//
		// Menu com botões
		//--------------------------------------------------------------------------------------------------------------------//
		// Excluindo o menu caso já exista
		if($("#menuAcessoRapidoColaborador").data("kendoContextMenu")){
			$("#menuAcessoRapidoColaborador").data("kendoContextMenu").destroy()
		}

		$("#frmConsultaColaborador #menuAcessoRapidoColaborador").kendoContextMenu({
			target: "#frmConsultaColaborador #BtnAcessoRapido",
			alignToAnchor: true,
			showOn:"click",
			select: function(e){
				var GrdConsultaColaborador = $("#frmConsultaColaborador #GrdConsultaColaborador").data("kendoGrid");
				var RstColaborador = GrdConsultaColaborador.dataItem(GrdConsultaColaborador.select());

				if(e.item.id == "BtnHistoricoAlocacao"){
					OpenWindow(false, "ConsultaAlocacao", "controller/alocacao/ctrAlocacao.php?action=winConsulta&idColaborador=" + RstColaborador.idcolaboradorequipamento, "Consulta Alocacao")
				}
			}
		})
		//--------------------------------------------------------------------------------------------------------------------//

    //--------------------------------------------------------------------------------------------------------------------//
		// Instanciando o data source da consulta
		//--------------------------------------------------------------------------------------------------------------------//
		let DtsConsultaColaborador = new kendo.data.DataSource({
			pageSize: 100,
			serverPaging: true,
			serverFiltering: true,
			serverSorting: true,
			transport: {
				read: {
					url: "controller/colaborador/ctrColaborador.php",
					type: "GET",
					dataType: "json",
					data: function(){
						return {
							action: "ListColaborador",
							filters: getExtraFilter()
						}
					}
				}
			},
			schema: {
				data: "jsnColaborador",
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
		$("#frmConsultaColaborador #BtnPesquisar").kendoButton({
			click: function () {
				DtsConsultaColaborador.filter(getExtraFilter())
				DtsConsultaColaborador.read()
			}
		})
		//--------------------------------------------------------------------------------------------------------------------//

    //--------------------------------------------------------------------------------------------------------------------//
		// Filto extra de consulta
		//--------------------------------------------------------------------------------------------------------------------//
		function getExtraFilter() {
			let arrFilds = LoadFilterSplitter("ConsultaColaborador", arrDataSource)
			return arrFilds;
		}
		//--------------------------------------------------------------------------------------------------------------------//

    //--------------------------------------------------------------------------------------------------------------------//
		// Instanciando o grid da consulta
		//--------------------------------------------------------------------------------------------------------------------//
		$("#frmConsultaColaborador #GrdConsultaColaborador").kendoGrid({
			pdf: SetPdfOptions("Listagem de Colaboradores"),
			pdfExport: function () {
				tituloPdfExport = "Listagem de Colaboradores"
			},
			dataSource: DtsConsultaColaborador,
			height: getHeightGridQuery("ConsultaColaborador"),
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
			columnShow: function (e) { setWidthOnShowColumnGrid(e, 'ConsultaColaborador'); },
			columnHide: function (e) { setWidthOnHideColumnGrid(e, 'ConsultaColaborador'); },
			filter: function (e) { mountFilteredScreen('filterColumn', e, 'ConsultaColaborador', arrDataSource, DtsConsultaColaborador, getExtraFilter()); },
			change: function () {
				$("#frmConsultaColaborador #BarAcoes").data("kendoToolBar").enable("#BtnEditar")
				$("#frmConsultaColaborador #BarAcoes").data("kendoToolBar").enable("#BtnAcessoRapido")				
				if("<?=$frmResult?>" != ""){
					$("#frmConsultaColaborador #BarAcoes").data("kendoToolBar").enable("#BtnSelecionar")
				}
			},
			dataBound: function () {
				LoadGridExportActions("frmConsultaColaborador", "GrdConsultaColaborador", true)
			}
		})

    $("#frmConsultaColaborador #GrdConsultaColaborador").on("dblclick", "tbody>tr", function(){
			if("<?=$frmResult?>" != ""){
				$("#frmConsultaColaborador #BtnSelecionar").click();
			} else {
				$("#frmConsultaColaborador #BtnEditar").click();
			}
		})
		//--------------------------------------------------------------------------------------------------------------------//

    //--------------------------------------------------------------------------------------------------------------------//
		//	Ação para abrir a tela de consulta
		//--------------------------------------------------------------------------------------------------------------------//
    $("#WinConsultaColaborador").data("kendoWindow").open();
    //--------------------------------------------------------------------------------------------------------------------//

    //--------------------------------------------------------------------------------------------------------------------//
		//	Cria a tela de vizualização do item
		//--------------------------------------------------------------------------------------------------------------------//
    createScreenPreview(arrDataSource, "ConsultaColaborador");
    //--------------------------------------------------------------------------------------------------------------------//

  })
</script>

<div class="k-form">
  <form id="frmConsultaColaborador">
    <div id="splConsulta">
      <div id="splHeader">
        <div class="k-bg-blue screen-filter-content">
          <table>
						<tr>
							<td style="width: 120px;text-align: right;vertical-align: top;padding-top: 6px;">
								Filtro(s):
							</td>

							<td>
								<div id="fltConsultaColaborador" style="width: auto;"></div>
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
        <div id="GrdConsultaColaborador" data-use-state-screen="true"></div>

				<ul id="menuAcessoRapidoColaborador" style="display: none;">
					<li id="BtnHistoricoAlocacao"><span class="k-pg-icon k-i-l3-c7"></span>&nbsp;Historico de alocacoes</li>
				</ul>
      </div>
      <div id="splFooter">
        <div id="bottonConsultaColaborador">
					<div id="tabStripConsultaColaborador">
						<ul>
							<li id="tabDadosGerais" class="k-state-active"><label>Detalhes</label></li>
						</ul>
						<div id="tabDadosGeraisVisualizacaoConsultaColaborador"></div>
					</div>
				</div>
      </div>
    </div>
  </form>
</div>