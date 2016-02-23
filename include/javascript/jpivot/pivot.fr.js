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
    return $.pivotUtilities.locales.fr = {
      localeStrings: {
        renderError: "Une erreur est survenue en dessinant le tableau crois&eacute;.",
        computeError: "Une erreur est survenue en calculant le tableau crois&eacute;.",
        uiRenderError: "Une erreur est survenue en dessinant l'interface du tableau crois&eacute; dynamique.",
        selectAll: "S&eacute;lectionner tout",
        selectNone: "S&eacute;lectionner rien",
        tooMany: "(trop de valeurs &agrave; afficher)",
        filterResults: "Filtrer les valeurs",
        totals: "Totaux",
        vs: "sur",
        by: "par"
      },
      aggregators: {
        "Nombre": tpl.count(frFmtInt),
        "Nombre de valeurs uniques": tpl.countUnique(frFmtInt),
        "Liste de valeurs uniques": tpl.listUnique(", "),
        "Somme": tpl.sum(frFmt),
        "Somme en entiers": tpl.sum(frFmtInt),
        "Moyenne": tpl.average(frFmt),
        "Minimum": tpl.min(frFmt),
        "Maximum": tpl.max(frFmt),
        "Ratio de sommes": tpl.sumOverSum(frFmt),
        "Borne sup&eacute;rieure 80%": tpl.sumOverSumBound80(true, frFmt),
        "Borne inf&eacute;rieure 80%": tpl.sumOverSumBound80(false, frFmt),
        "Somme en proportion du totale": tpl.fractionOf(tpl.sum(), "total", frFmtPct),
        "Somme en proportion de la ligne": tpl.fractionOf(tpl.sum(), "row", frFmtPct),
        "Somme en proportion de la colonne": tpl.fractionOf(tpl.sum(), "col", frFmtPct),
        "Nombre en proportion du totale": tpl.fractionOf(tpl.count(), "total", frFmtPct),
        "Nombre en proportion de la ligne": tpl.fractionOf(tpl.count(), "row", frFmtPct),
        "Nombre en proportion de la colonne": tpl.fractionOf(tpl.count(), "col", frFmtPct)
      },
      renderers: {
        "Table": $.pivotUtilities.renderers["Table"],
        "Table avec barres": $.pivotUtilities.renderers["Table Barchart"],
        "Carte de chaleur": $.pivotUtilities.renderers["Heatmap"],
        "Carte de chaleur par ligne": $.pivotUtilities.renderers["Row Heatmap"],
        "Carte de chaleur par colonne": $.pivotUtilities.renderers["Col Heatmap"]
      }
    };
  });

}).call(this);

//# sourceMappingURL=pivot.fr.js.map
