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
    var c3r, d3r, frFmt, frFmtInt, frFmtPct, gcr, nf, r, tpl;
    nf = $.pivotUtilities.numberFormat;
    tpl = $.pivotUtilities.aggregatorTemplates;
    r = $.pivotUtilities.renderers;
    gcr = $.pivotUtilities.gchart_renderers;
    d3r = $.pivotUtilities.d3_renderers;
    c3r = $.pivotUtilities.c3_renderers;
    frFmt = nf({
      thousandsSep: ".",
      decimalSep: ","
    });
    frFmtInt = nf({
      digitsAfterDecimal: 0,
      thousandsSep: ".",
      decimalSep: ","
    });
    frFmtPct = nf({
      digitsAfterDecimal: 2,
      scaler: 100,
      suffix: "%",
      thousandsSep: ".",
      decimalSep: ","
    });
    $.pivotUtilities.locales.tr = {
      localeStrings: {
        renderError: "PivotTable sonu&ccedil;lar&#305;n&#305; olu&#351;tuturken hata olu&#351;tu",
        computeError: "PivotTable sonu&ccedil;lar&#305;n&#305; i&#351;lerken hata olu&#351;tu",
        uiRenderError: "PivotTable UI sonu&ccedil;lar&#305;n&#305; olu&#351;tuturken hata olu&#351;tu",
        selectAll: "T&uuml;m&uuml;n&uuml; Se&ccedil;",
        selectNone: "T&uuml;m&uuml;n&uuml; B&#305;rak",
        tooMany: "(listelemek i&ccedil;in fazla)",
        filterResults: "Sonu&ccedil;lar&#305; filtrele",
        totals: "Toplam",
        vs: "vs",
        by: "ile"
      },
      aggregators: {
        "Say&#305;": tpl.count(frFmtInt),
        "Benzersiz de&#287;erler say&#305;s&#305;": tpl.countUnique(frFmtInt),
        "Benzersiz de&#287;erler listesi": tpl.listUnique(", "),
        "Toplam": tpl.sum(frFmt),
        "Toplam (tam say&#305;)": tpl.sum(frFmtInt),
        "Ortalama": tpl.average(frFmt),
        "Min": tpl.min(frFmt),
        "Maks": tpl.max(frFmt),
        "Miktarlar&#305;n toplam&#305;": tpl.sumOverSum(frFmt),
        "%80 daha y&uuml;ksek": tpl.sumOverSumBound80(true, frFmt),
        "%80 daha d&uuml;&#351;&uuml;k": tpl.sumOverSumBound80(false, frFmt),
        "Toplam oran&#305; (toplam)": tpl.fractionOf(tpl.sum(), "total", frFmtPct),
        "Sat&#305;r oran&#305; (toplam)": tpl.fractionOf(tpl.sum(), "row", frFmtPct),
        "S&uuml;tunun oran&#305; (toplam)": tpl.fractionOf(tpl.sum(), "col", frFmtPct),
        "Toplam oran&#305; (say&#305;)": tpl.fractionOf(tpl.count(), "total", frFmtPct),
        "Sat&#305;r oran&#305; (say&#305;)": tpl.fractionOf(tpl.count(), "row", frFmtPct),
        "S&uuml;tunun oran&#305; (say&#305;)": tpl.fractionOf(tpl.count(), "col", frFmtPct)
      },
      renderers: {
        "Tablo": r["Table"],
        "Tablo (&Ccedil;ubuklar)": r["Table Barchart"],
        "&#304;lgi haritas&#305;": r["Heatmap"],
        "Sat&#305;r ilgi haritas&#305;": r["Row Heatmap"],
        "S&uuml;tun ilgi haritas&#305;": r["Col Heatmap"]
      }
    };
    if (gcr) {
      $.pivotUtilities.locales.tr.gchart_renderers = {
        "&Ccedil;izgi Grafi&#287;i": gcr["Line Chart"],
        "Bar Grafi&#287;i": gcr["Bar Chart"],
        "Y&#305;&#287;&#305;lm&#305;&#351; &Ccedil;ubuk Grafik ": gcr["Stacked Bar Chart"],
        "Alan Grafi&#287;i": gcr["Area Chart"]
      };
    }
    if (d3r) {
      $.pivotUtilities.locales.tr.d3_renderers = {
        "Hiyerar&#351;ik Alan Grafi&#287;i (Treemap)": d3r["Treemap"]
      };
    }
    if (c3r) {
      $.pivotUtilities.locales.tr.c3_renderers = {
        "&Ccedil;izgi Grafi&#287;i": c3r["Line Chart"],
        "Bar Grafi&#287;i": c3r["Bar Chart"],
        "Y&#305;&#287;&#305;lm&#305;&#351; &Ccedil;ubuk Grafik ": c3r["Stacked Bar Chart"],
        "Alan Grafi&#287;i": c3r["Area Chart"]
      };
    }
    return $.pivotUtilities.locales.tr;
  });

}).call(this);

//# sourceMappingURL=pivot.tr.js.map
