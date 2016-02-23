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
        renderError: "Er is een fout opgetreden bij het renderen van de kruistabel..",
        computeError: "Er is een fout opgetreden bij het berekenen van de kruistabel.",
        uiRenderError: "Er is een fout opgetreden bij het tekenen van de interface van de kruistabel.",
        selectAll: "Alles selecteren",
        selectNone: "Niets selecteren",
        tooMany: "(te veel waarden om weer te geven)",
        filterResults: "Filter resultaten",
        totals: "Totaal",
        vs: "versus",
        by: "per"
      },
      aggregators: {
        "Aantal": tpl.count(frFmtInt),
        "Aantal unieke waarden": tpl.countUnique(frFmtInt),
        "Lijst unieke waarden": tpl.listUnique(", "),
        "Som": tpl.sum(frFmt),
        "Som van gehele getallen": tpl.sum(frFmtInt),
        "Gemiddelde": tpl.average(frFmt),
        "Minimum": tpl.min(frFmt),
        "Maximum": tpl.max(frFmt),
        "Som over som": tpl.sumOverSum(frFmt),
        "80% bovengrens": tpl.sumOverSumBound80(true, frFmt),
        "80% ondergrens": tpl.sumOverSumBound80(false, frFmt),
        "Som in verhouding tot het totaal": tpl.fractionOf(tpl.sum(), "total", frFmtPct),
        "Som in verhouding tot de rij": tpl.fractionOf(tpl.sum(), "row", frFmtPct),
        "Som in verhouding tot de kolom": tpl.fractionOf(tpl.sum(), "col", frFmtPct),
        "Aantal in verhouding tot het totaal": tpl.fractionOf(tpl.count(), "total", frFmtPct),
        "Aantal in verhouding tot de rij": tpl.fractionOf(tpl.count(), "row", frFmtPct),
        "Aantal in verhouding tot de kolom": tpl.fractionOf(tpl.count(), "col", frFmtPct)
      },
      renderers: {
        "Tabel": $.pivotUtilities.renderers["Table"],
        "Tabel met staafdiagrammen": $.pivotUtilities.renderers["Table Barchart"],
        "Warmtekaart": $.pivotUtilities.renderers["Heatmap"],
        "Warmtekaart per rij": $.pivotUtilities.renderers["Row Heatmap"],
        "Warmtekaart per kolom": $.pivotUtilities.renderers["Col Heatmap"]
      }
    };
  });

}).call(this);

//# sourceMappingURL=pivot.nl.js.map
