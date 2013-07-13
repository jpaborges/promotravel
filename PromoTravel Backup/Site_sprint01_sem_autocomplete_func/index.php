<!DOCTYPE html>
<html>
<head>
    <title>Promotravel</title>
    <link rel="shortcut icon" href="http://imageshack.us/a/img443/9893/faviconww.png" type="image/png" />
    <link type="text/css" href="css/ui-lightness/jquery-ui-1.8.23.custom.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="css/master.css" />
    <script type="text/javascript" src="js/jquery-1.8.1.min.js"></script>
    <script type="text/javascript" src="js/jquery-ui-1.8.23.autocomplete.start.with.min.js"></script>
    <script type="text/javascript" src="js/animations.js"></script>
    <script type="text/javascript" src="js/master.js"></script>
    <script type="text/javascript" src="js/validation.js"></script>
</head>
<body>
    <div id="main-container">
        <div id="logo">
            <img src="imgs/logo_main.png" alt="Logo Promotravel" /></div>
            <div id="btn-container">
                <div class="btn-moldura">
                    <input tabindex="1" type="image" onClick="changecontent('SolicitarPesquisa.html')" class="btn-main" id="btn-acompanhar" src="imgs/btn_acompanhar.png"
                    alt="button - Acompanhar Passagem" />
                </div>
                <div class="btn-moldura">
                    <input tabindex="2" type="image" onClick="changecontent('VerificarPesquisa.html')" class="btn-main" id="btn-verificar" src="imgs/btn_verificar.png"
                    alt="Botão - Verificar Pesquisa" />
                </div>
                <div class="btn-moldura">
                    <input tabindex="3" type="image" onClick="changecontent('Sobre.html')" class="btn-main" id="btn-quem" src="imgs/btn_quem.png"
                    alt="Botão - Quem somos" />
                </div>
                <div class="btn-moldura">
                    <input tabindex="4" type="image" onClick="changecontent('FaleConosco.html')" id="btn-fale" class="btn-main " src="imgs/btn_fale.png"
                    alt="Botão - Fale Conosco" />
                </div>
            </div>
            <iframe class="facebook-plugin" src="http://www.facebook.com/plugins/likebox.php?href=http%3A%2F%2Fwww.facebook.com%2Fpromotravelbr&amp;width=292&amp;height=258&amp;colorscheme=light&amp;show_faces=true&amp;border_color&amp;stream=false&amp;header=false">
            </iframe>
            <img class="facebook-preloader" src="imgs\preloader.gif" alt="loading" />
            <div id="ajax">


                <div id="content">
    <!-- CONTENT PANEL - BEGIN -->
    <div class="form">
        <h1>
            Dados da viagem</h1>
            <h2>
                Os itens com "*"(aster&iacute;stico) são obrigat&oacute;rios!</h2>
                <div class="list-error radius-10" id="dados-viagem">
                    <p class="title">
                        Corrija o(s) seguinte(s) itens(s):</p>
                        <ol>
                            <li><b>"Nome do input com erro"</b>: Descição de como resolver o problema (lembrar de
                                add class input-erro no input).</li>
                                <!-- <li><b>2. </b><b>"dd/mm/yyyy"</b> e <b>"dd/mm/yyyy"</b>: Esse conjunto de datas já foi inserido.</li>-->
                            </ol>
                        </div>
                        <fieldset class="left-col">
                            <dl>
                                <dt>Ida e volta*:</dt></dl>
                                <dl>
                                    <dt>Somente ida*:</dt></dl>

                                    <dl>
                                        <dt>Origem*:</dt></dl>
                                        <dl>
                                            <dt>Destino*:</dt></dl>
                                            <dl>
                                                <dt>Pre&ccedil;o esperado(R$)*:</dt>
                                            </dl>
                                        </fieldset>
                                        <fieldset class="right-col">
                                            <dl>
                                                <dd>
                                                    <input tabindex="6" type="radio" name="tipoDaViagem" onclick="validate_radio();" checked="checked" value="Ida e Volta" /></dd></dl>
                                                    <dl>
                                                        <dd>
                                                            <input tabindex="5" type="radio" name="tipoDaViagem" onclick="validate_radio();" value="Somente Ida"/></dd>
                                                        </dl>

                                                        <dl>
                                                            <dd>
                                                                <input tabindex="7" type="text" name="origem" id="origem" class="input-l" onblur="validate_city('origem');"/></dd>
                                                            </dl>
                                                            <dl>
                                                                <dd>
                                                                    <input tabindex="8" type="text" name="destino" id="destino" class="input-l" onblur="validate_city('destino');"/></dd>
                                                                </dl>
                                                                <dl>
                                                                    <dd>
                                                                        <input tabindex="9" type="text" name="precoesperado" class="input-s" onkeypress="return validate_value(this,'.',',',event);" /></dd>
                                                                    </dl>
                                                                </fieldset>
                                                                <h1>
                                                                    Poss&iacute;veis Datas</h1>
                                                                    <div class="list-error radius-10" id="possiveis-datas">
                                                                        <p class="title">
                                                                            Corrija o(s) seguinte(s) itens(s):</p>
                                                                            <ol>
                                                                                <li><b>"Data de Ida"</b> e <b>"Data de Volta"</b>: Os dois campos de data devem ser
                                                                                    preenchidos.</li>
                                                                                    <!-- <li><b>2. </b><b>"dd/mm/yyyy"</b> e <b>"dd/mm/yyyy"</b>: Esse conjunto de datas já foi inserido.</li>-->
                                                                                </ol>
                                                                            </div>
                                                                            <div class="half-col" start="2">
                                                                                <fieldset>
                                                                                    <dl>
                                                                                        <dt>Data de ida*:</dt>
                                                                                    </dl>
                                                                                </fieldset>
                                                                                <fieldset>
                                                                                    <dl>
                                                                                        <dd>
                                                                                            <input tabindex="10" type="text" name="dataIda" class="input-s datepicker" />
                                                                                            <!--                                <input tabindex="11" type="image" name="calendarIda" src="imgs/calendar_icon.png" alt="Calendário" />-->
                                                                                        </dd>
                                                                                    </dl>
                                                                                </fieldset>
                                                                            </div>
                                                                            <div class="half-col top-right-radius-15">
                                                                                <fieldset>
                                                                                    <dl>
                                                                                        <dt>Data de Volta*:</dt>
                                                                                    </dl>
                                                                                </fieldset>
                                                                                <fieldset>
                                                                                    <dl>
                                                                                        <dd>
                                                                                            <input tabindex="13" type="text" id="volta" name="dataVolta" class="input-s datepicker" />
                                                                                            <!--<input tabindex="14" type="image" name="calendarVolta" src="imgs/calendar_icon.png" alt="Calendário" />-->
                                                                                        </dd>
                                                                                    </dl>
                                                                                </fieldset>
                                                                            </div>
                                                                            <div class="button-col-2">
                                                                                <input type="button" class="btn-blue" value="Inserir Datas" name="inserirDatas" />
                                                                            </div>
                                                                            <div class="list-date">
                                                                                <div class="empty-list">
                                                                                    Lista Vazia - Digite os campos dispon&iacute;veis a cima e clique em "Inserir Datas"</div>
                                                                                    <!--<div class="item-date"> <label>Ida:dd/mm/yyyy </label><label>Volta:dd/mm/yyyy </label><input type="image" src="imgs\close_icon.png"/> </div>-->
                                                                                </div>
                                                                                <h1>
                                                                                    Contato</h1>
                                                                                    <fieldset class="left-col">
                                                                                        <dl>
                                                                                            <dt>E-mail*:</dt></dl>
                                                                                        </fieldset>
                                                                                        <fieldset class="right-col">
                                                                                            <dl>
                                                                                                <dd>
                                                                                                    <input type="text" name="email" id="email" class="input-l " onblur="validate_email();" alt="e-mail" /></dd>
                                                                                                </dl>
                    <!--<dl>
                        <dt class="erro">E-mail inválido!</dt>
                    </dl>-->
                </fieldset>
            </div>
            <div class="button-col">
                <input type="button" class="btn-green" value="Solicitar Pesquisa" />
            </div>
            <!-- CONTENT PANEL - END-->
        </div>


              <!--<script type="text/javascript">
              changecontent('SolicitarPesquisa.html');
          </script> -->




          </div>
          <div id="footer">
            <a href="#">Solicitar Pesquisa</a> <a href="#">Verificar Pesquisa</a> <a href="#">Quem
            Somos</a> <a href="#">Fale Conosco</a>
            <p>
                All Copy Rights &copy; Reseverds for<img src="imgs/logo_footer.png" alt="Logo Promotravel" /></p>
            </div>
        </div>
        <div id="lightbox">
        </div>
        <div class="centralizing">
        </div>
    </body>
    </html> 