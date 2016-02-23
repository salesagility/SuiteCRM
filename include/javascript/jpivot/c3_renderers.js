(function() {
  var callWithJQuery;

  callWithJQuery = function(pivotModule) {
    if (typeof exports === "object" && typeof module === "object") {
      return pivotModule(require("jquery"), require("c3"));
    } else if (typeof define === "function" && define.amd) {
      return define(["jquery", "c3"], pivotModule);
    } else {
      return pivotModule(jQuery, c3);
    }
  };

  callWithJQuery(function($, c3) {
    var makeC3Chart;
    makeC3Chart = function(chartOpts) {
      if (chartOpts == null) {
        chartOpts = {};
      }
      return function(pivotData, opts) {
        var agg, attrs, base, base1, base2, base3, base4, base5, colKey, colKeys, columns, dataColumns, defaults, fullAggName, groupByTitle, h, hAxisTitle, headers, i, j, k, l, len, len1, len2, len3, len4, m, numCharsInHAxis, numSeries, params, ref, ref1, ref2, ref3, renderArea, result, rotationAngle, row, rowHeader, rowKey, rowKeys, s, scatterData, series, title, titleText, vAxisTitle, val, vals, x, xs;
        defaults = {
          localeStrings: {
            vs: "vs",
            by: "by"
          },
          c3: {}
        };
        opts = $.extend(true, defaults, opts);
        if ((base = opts.c3).size == null) {
          base.size = {};
        }
        if ((base1 = opts.c3.size).width == null) {
          base1.width = window.innerWidth / 1.4;
        }
        if ((base2 = opts.c3.size).height == null) {
          base2.height = window.innerHeight / 1.4 - 50;
        }
        if (chartOpts.type == null) {
          chartOpts.type = "line";
        }
        rowKeys = pivotData.getRowKeys();
        if (rowKeys.length === 0) {
          rowKeys.push([]);
        }
        colKeys = pivotData.getColKeys();
        if (colKeys.length === 0) {
          colKeys.push([]);
        }
        headers = (function() {
          var i, len, results;
          results = [];
          for (i = 0, len = colKeys.length; i < len; i++) {
            h = colKeys[i];
            results.push(h.join("-"));
          }
          return results;
        })();
        rotationAngle = 0;
        fullAggName = pivotData.aggregatorName;
        if (pivotData.valAttrs.length) {
          fullAggName += "(" + (pivotData.valAttrs.join(", ")) + ")";
        }
        if (chartOpts.type === "scatter") {
          scatterData = {
            x: {},
            y: {},
            t: {}
          };
          attrs = pivotData.rowAttrs.concat(pivotData.colAttrs);
          vAxisTitle = (ref = attrs[0]) != null ? ref : "";
          hAxisTitle = (ref1 = attrs[1]) != null ? ref1 : "";
          groupByTitle = attrs.slice(2).join("-");
          titleText = vAxisTitle;
          if (hAxisTitle !== "") {
            titleText += " " + opts.localeStrings.vs + " " + hAxisTitle;
          }
          if (groupByTitle !== "") {
            titleText += " " + opts.localeStrings.by + " " + groupByTitle;
          }
          for (i = 0, len = rowKeys.length; i < len; i++) {
            rowKey = rowKeys[i];
            for (j = 0, len1 = colKeys.length; j < len1; j++) {
              colKey = colKeys[j];
              agg = pivotData.getAggregator(rowKey, colKey);
              if (agg.value() != null) {
                vals = rowKey.concat(colKey);
                series = vals.slice(2).join("-");
                if (series === "") {
                  series = "series";
                }
                if ((base3 = scatterData.x)[series] == null) {
                  base3[series] = [];
                }
                if ((base4 = scatterData.y)[series] == null) {
                  base4[series] = [];
                }
                if ((base5 = scatterData.t)[series] == null) {
                  base5[series] = [];
                }
                scatterData.y[series].push((ref2 = vals[0]) != null ? ref2 : 0);
                scatterData.x[series].push((ref3 = vals[1]) != null ? ref3 : 0);
                scatterData.t[series].push(agg.format(agg.value()));
              }
            }
          }
        } else {
          numCharsInHAxis = 0;
          for (k = 0, len2 = headers.length; k < len2; k++) {
            x = headers[k];
            numCharsInHAxis += x.length;
          }
          if (numCharsInHAxis > 50) {
            rotationAngle = 45;
          }
          columns = [];
          for (l = 0, len3 = rowKeys.length; l < len3; l++) {
            rowKey = rowKeys[l];
            rowHeader = rowKey.join("-");
            row = [rowHeader === "" ? pivotData.aggregatorName : rowHeader];
            for (m = 0, len4 = colKeys.length; m < len4; m++) {
              colKey = colKeys[m];
              val = parseFloat(pivotData.getAggregator(rowKey, colKey).value());
              if (isFinite(val)) {
                if (val < 1) {
                  row.push(val.toPrecision(3));
                } else {
                  row.push(val.toFixed(3));
                }
              } else {
                row.push(null);
              }
            }
            columns.push(row);
          }
          vAxisTitle = pivotData.aggregatorName + (pivotData.valAttrs.length ? "(" + (pivotData.valAttrs.join(", ")) + ")" : "");
          hAxisTitle = pivotData.colAttrs.join("-");
          titleText = fullAggName;
          if (hAxisTitle !== "") {
            titleText += " " + opts.localeStrings.vs + " " + hAxisTitle;
          }
          groupByTitle = pivotData.rowAttrs.join("-");
          if (groupByTitle !== "") {
            titleText += " " + opts.localeStrings.by + " " + groupByTitle;
          }
        }
        title = $("<p>", {
          style: "text-align: center; font-weight: bold"
        });
        title.text(titleText);
        params = {
          axis: {
            y: {
              label: vAxisTitle
            },
            x: {
              label: hAxisTitle,
              tick: {
                rotate: rotationAngle,
                multiline: false
              }
            }
          },
          data: {
            type: chartOpts.type
          },
          tooltip: {
            grouped: false
          },
          color: {
            pattern: ["#3366cc", "#dc3912", "#ff9900", "#109618", "#990099", "#0099c6", "#dd4477", "#66aa00", "#b82e2e", "#316395", "#994499", "#22aa99", "#aaaa11", "#6633cc", "#e67300", "#8b0707", "#651067", "#329262", "#5574a6", "#3b3eac"]
          }
        };
        $.extend(params, opts.c3);
        if (chartOpts.type === "scatter") {
          xs = {};
          numSeries = 0;
          dataColumns = [];
          for (s in scatterData.x) {
            numSeries += 1;
            xs[s] = s + "_x";
            dataColumns.push([s + "_x"].concat(scatterData.x[s]));
            dataColumns.push([s].concat(scatterData.y[s]));
          }
          params.data.xs = xs;
          params.data.columns = dataColumns;
          params.axis.x.tick = {
            fit: false
          };
          if (numSeries === 1) {
            params.legend = {
              show: false
            };
          }
          params.tooltip.format = {
            title: function() {
              return fullAggName;
            },
            name: function() {
              return "";
            },
            value: function(a, b, c, d) {
              return scatterData.t[c][d];
            }
          };
        } else {
          params.axis.x.type = 'category';
          params.axis.x.categories = headers;
          params.data.columns = columns;
        }
        if (chartOpts.stacked != null) {
          params.data.groups = [
            (function() {
              var len5, n, results;
              results = [];
              for (n = 0, len5 = rowKeys.length; n < len5; n++) {
                x = rowKeys[n];
                results.push(x.join("-"));
              }
              return results;
            })()
          ];
        }
        renderArea = $("<div>", {
          style: "display:none;"
        }).appendTo($("body"));
        result = $("<div>").appendTo(renderArea);
        params.bindto = result[0];
        c3.generate(params);
        result.detach();
        renderArea.remove();
        return $("<div>").append(title, result);
      };
    };
    return $.pivotUtilities.c3_renderers = {
      "Line Chart": makeC3Chart(),
      "Bar Chart": makeC3Chart({
        type: "bar"
      }),
      "Stacked Bar Chart": makeC3Chart({
        type: "bar",
        stacked: true
      }),
      "Area Chart": makeC3Chart({
        type: "area",
        stacked: true
      }),
      "Scatter Chart": makeC3Chart({
        type: "scatter"
      })
    };
  });

}).call(this);

//# sourceMappingURL=c3_renderers.js.map
