(function() {
  var callWithJQuery;

  callWithJQuery = function(pivotModule) {
    if (typeof exports === "object" && typeof module === "object") {
      return pivotModule(require("jquery"));
    } else if (typeof define === "function" && define.amd) {
      return define(["jquery"], pivotModule);
    } else {
      return pivotModule(jQuery);
    }
  };

  callWithJQuery(function($) {
    var frFmt, frFmtInt, frFmtPct, nf, tpl;
    nf = $.pivotUtilities.numberFormat;
    tpl = $.pivotUtilities.aggregatorTemplates;
    frFmt = nf({
      thousandsSep: " ",
      decimalSep: ","
    });
    frFmtInt = nf({
      digitsAfterDecimal: 0,
      thousandsSep: " ",
      decimalSep: ","
    });
    frFmtPct = nf({
      digitsAfterDecimal: 1,
      scaler: 100,
      suffix: "%",
      thousandsSep: " ",
      decimalSep: ","
    });
    return $.pivotUtilities.locales.es = {
      localeStrings: {
        renderError: "Ocurri&oacute; un error durante la interpretaci&oacute;n de la tabla din&acute;mica.",
        computeError: "Ocurri&oacute; un error durante el c&acute;lculo de la tabla din&acute;mica.",
        uiRenderError: "Ocurri&oacute; un error durante el dibujado de la tabla din&acute;mica.",
        selectAll: "Seleccionar todo",
        selectNone: "Deseleccionar todo",
        tooMany: "(demasiados valores)",
        filterResults: "Filtrar resultados",
        totals: "Totales",
        vs: "vs",
        by: "por"
      },
      aggregators: {
        "Cuenta": tpl.count(frFmtInt),
        "Cuenta de valores &uacute;nicos": tpl.countUnique(frFmtInt),
        "Lista de valores &uacute;nicos": tpl.listUnique(", "),
        "Suma": tpl.sum(frFmt),
        "Suma de enteros": tpl.sum(frFmtInt),
        "Promedio": tpl.average(frFmt),
        "Mínimo": tpl.min(frFmt),
        "Máximo": tpl.max(frFmt),
        "Suma de sumas": tpl.sumOverSum(frFmt),
        "Cota 80% superior": tpl.sumOverSumBound80(true, frFmt),
        "Cota 80% inferior": tpl.sumOverSumBound80(false, frFmt),
        "Proporci&oacute;n del total (suma)": tpl.fractionOf(tpl.sum(), "total", frFmtPct),
        "Proporci&oacute;n de la fila (suma)": tpl.fractionOf(tpl.sum(), "row", frFmtPct),
        "Proporci&oacute;n de la columna (suma)": tpl.fractionOf(tpl.sum(), "col", frFmtPct),
        "Proporci&oacute;n del total (cuenta)": tpl.fractionOf(tpl.count(), "total", frFmtPct),
        "Proporci&oacute;n de la fila (cuenta)": tpl.fractionOf(tpl.count(), "row", frFmtPct),
        "Proporci&oacute;n de la columna (cuenta)": tpl.fractionOf(tpl.count(), "col", frFmtPct)
      },
      renderers: {
        "Tabla": $.pivotUtilities.renderers["Table"],
        "Tabla con barras": $.pivotUtilities.renderers["Table Barchart"],
        "Heatmap": $.pivotUtilities.renderers["Heatmap"],
        "Heatmap por filas": $.pivotUtilities.renderers["Row Heatmap"],
        "Heatmap por columnas": $.pivotUtilities.renderers["Col Heatmap"]
      }
    };
  });

}).call(this);

//# sourceMappingURL=pivot.es.js.map
