/*
 * Configuracoes de linguagem da agenda
 *
 */
var agenda_locale = [];
agenda_locale['pt-br'] = {
	monthNames: ['Janeiro','Fevereiro','Mar&ccedil;o','Abril','Maio','Junho','Julho','Agosto',
	'Setembro','Outubro','Novembro','Dezembro'
	],
	monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
	dayNames: ['Domingo','Segunda','Ter�a','Quarta','Quinta','Sexta','S&aacute;bado'],
	dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sab'],
	header: { left:'prev', center:'title', right:'next' },
	buttonText: {
        prev: '&nbsp;&#9668;&nbsp;',      // left triangle
        next: '&nbsp;&#9658;&nbsp;',      // right triangle
        prevYear: '&nbsp;&lt;&lt;&nbsp;', // <<
        nextYear: '&nbsp;&gt;&gt;&nbsp;', // >>
        today: 'Data atual',
        month: 'm&ecirc;s',
        week: 'semana',
        day: 'dia'
	}
};
