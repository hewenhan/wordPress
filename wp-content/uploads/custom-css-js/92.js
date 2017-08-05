/******* Do not edit this file *******
Simple Custom CSS and JS - by Silkypress.com
Saved: Aug 05 2017 | 04:35:00 */
var margeObj = function (obj1, obj2) {
	this.arrayUnique = function(array){
		if (array instanceof Array === false) {
			throw "ARGEMENTS TYPE IS NOT ARRAY";
		}
		array.sort(function (a, b) {return a - b});
		var result = [array[0]];
		for(var i = 1; i < array.length; i++){
			if (result.indexOf(array[i]) === -1) {
				result.push(array[i]);
			}
		}
		return result;
	}

	this.jsonSortByKeys = function (json) {
		var keys = Object.keys(json);
		keys.sort();
		var result = {};
		for (var i = 0; i < keys.length; i++) {
			result[keys[i]] = json[keys[i]];
		}
		return result;
	};

	this.checkVarBothType = function (var1, var2) {
		if (var1 instanceof Array && var2 instanceof Array) {
			return "array";
		}
		if (var1 instanceof Array === false && var2 instanceof Array === false && var1 instanceof Object && var2 instanceof Object) {
			return "object";
		}
		if (var1 instanceof Function && var2 instanceof Function) {
			return "function";
		}
		if (var1 instanceof String && var2 instanceof String) {
			return "string";
		}
		if (var1 instanceof Number && var2 instanceof Number) {
			return "number";
		}
		if (var1 instanceof Boolean && var2 instanceof Boolean) {
			return "boolean";
		}
		return "different";
	};

	this.margeObjLoop = function (obj1, obj2) {
		if (checkVarBothType(obj1, obj2) !== 'object') {
			throw  "ARGEMENTS TYPE IS NOT OBJECT";
		}

		var cell1 = jsonSortByKeys(obj1);
		var cell2 = jsonSortByKeys(obj2);

		for (var i in cell2) {
			if (checkVarBothType(cell1[i], cell2[i]) == "array") {
				cell1[i] = arrayUnique(cell1[i].concat(cell2[i]));
				continue;
			}
			if (checkVarBothType(cell1[i], cell2[i]) == "object") {
				cell1[i] = jsonSortByKeys(margeObjLoop(cell1[i], cell2[i]));
				continue;
			}
			cell1[i] = cell2[i];
		}

		return jsonSortByKeys(cell1);
	};

	return this.margeObjLoop(obj1, obj2);
};

var margeObjTest = function () {
	var obj1Str = document.getElementById('obj1').value;
	var obj2Str = document.getElementById('obj2').value;

	eval("var obj1 = " + obj1Str);
	eval("var obj2 = " + obj2Str);

	var result = JSON.stringify(margeObj(obj1, obj2));

	document.getElementById('margeObjTestResult').value = result;
};

console.log('mergobj is on load');