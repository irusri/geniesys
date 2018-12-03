require({cache:{
'JBrowse/Model/DataView':function(){
/**
 * Subclass of jDataView with a getUint64 method.
 */
define("JBrowse/Model/DataView", [
           'jDataView'
       ],
       function( jDataView ) {

var DataView = function() {
    jDataView.apply( this, arguments );
};

try {
    DataView.prototype = new jDataView( new ArrayBuffer([1]), 0, 1 );
} catch(e) {
    console.error(e);
}

/**
 * Get a 53-bit integer from 64 bits and approximate the number if it overflows.
 */
DataView.prototype.getUint64Approx = function( byteOffset, littleEndian ) {
    var b = this._getBytes(8, byteOffset, littleEndian);
    var result = b[0] * Math.pow(2,56) + b[1]*Math.pow(2,48) + b[2]*Math.pow(2,40) + b[3]*Math.pow(2,32) +  b[4]*Math.pow(2, 24) + (b[5]<<16) + (b[6]<<8) + b[7];

    if( b[0] || b[1]&224 ) {
        result = new Number(result);
        result.overflow = true;
    }

    return result;
};

/**
 * Get a 53-bit integer from 64 bits and throw if it overflows.
 */
DataView.prototype.getUint64 = function( byteOffset, littleEndian ) {
    var result = this.getUint64Approx( byteOffset, littleEndian );
    if( result.overflow )
        throw new Error('integer overflow');
    return result;
};


return DataView;

});
},
'jDataView/jdataview':function(){
define("jDataView/jdataview", [], function() {
var scope = {};

//
// jDataView by Vjeux - Jan 2010
//
// A unique way to read a binary file in the browser
// http://github.com/vjeux/jDataView
// http://blog.vjeux.com/ <vjeuxx@gmail.com>
//

(function (global) {

var compatibility = {
	ArrayBuffer: typeof ArrayBuffer !== 'undefined',
	DataView: typeof DataView !== 'undefined' &&
		('getFloat64' in DataView.prototype ||				// Chrome
		 'getFloat64' in new DataView(new ArrayBuffer(1))), // Node
	// NodeJS Buffer in v0.5.5 and newer
	NodeBuffer: typeof Buffer !== 'undefined' && 'readInt16LE' in Buffer.prototype
};

var dataTypes = {
	'Int8': 1,
	'Int16': 2,
	'Int32': 4,
	'Uint8': 1,
	'Uint16': 2,
	'Uint32': 4,
	'Float32': 4,
	'Float64': 8
};

var nodeNaming = {
	'Int8': 'Int8',
	'Int16': 'Int16',
	'Int32': 'Int32',
	'Uint8': 'UInt8',
	'Uint16': 'UInt16',
	'Uint32': 'UInt32',
	'Float32': 'Float',
	'Float64': 'Double'
};

var jDataView = function (buffer, byteOffset, byteLength, littleEndian) {
	if (!(this instanceof jDataView)) {
		throw new Error("jDataView constructor may not be called as a function");
	}

	this.buffer = buffer;

	// Handle Type Errors
	if (!(compatibility.NodeBuffer && buffer instanceof Buffer) &&
		!(compatibility.ArrayBuffer && buffer instanceof ArrayBuffer) &&
		typeof buffer !== 'string') {
		throw new TypeError('jDataView buffer has an incompatible type');
	}

	// Check parameters and existing functionnalities
	this._isArrayBuffer = compatibility.ArrayBuffer && buffer instanceof ArrayBuffer;
	this._isDataView = compatibility.DataView && this._isArrayBuffer;
	this._isNodeBuffer = compatibility.NodeBuffer && buffer instanceof Buffer;

	// Default Values
	this._littleEndian = Boolean(littleEndian);

	var bufferLength = this._isArrayBuffer ? buffer.byteLength : buffer.length;
	if (byteOffset === undefined) {
		byteOffset = 0;
	}
	this.byteOffset = byteOffset;

	if (byteLength === undefined) {
		byteLength = bufferLength - byteOffset;
	}
	this.byteLength = byteLength;

	if (!this._isDataView) {
		// Do additional checks to simulate DataView
		if (typeof byteOffset !== 'number') {
			throw new TypeError('jDataView byteOffset is not a number');
		}
		if (typeof byteLength !== 'number') {
			throw new TypeError('jDataView byteLength is not a number');
		}
		if (byteOffset < 0) {
			throw new Error('jDataView byteOffset is negative');
		}
		if (byteLength < 0) {
			throw new Error('jDataView byteLength is negative');
		}
	}

	// Instanciate
	if (this._isDataView) {
		this._view = new DataView(buffer, byteOffset, byteLength);
		this._start = 0;
	}
	this._start = byteOffset;
	if (byteOffset + byteLength > bufferLength) {
		throw new Error("jDataView (byteOffset + byteLength) value is out of bounds");
	}

	this._offset = 0;

	// Create uniform reading methods (wrappers) for the following data types

	if (this._isDataView) { // DataView: we use the direct method
		for (var type in dataTypes) {
			if (!dataTypes.hasOwnProperty(type)) {
				continue;
			}
			(function(type, view){
				var size = dataTypes[type];
				view['get' + type] = function (byteOffset, littleEndian) {
					// Handle the lack of endianness
					if (littleEndian === undefined) {
						littleEndian = view._littleEndian;
					}

					// Handle the lack of byteOffset
					if (byteOffset === undefined) {
						byteOffset = view._offset;
					}

					// Move the internal offset forward
					view._offset = byteOffset + size;

					return view._view['get' + type](byteOffset, littleEndian);
				};
			})(type, this);
		}
	} else if (this._isNodeBuffer && compatibility.NodeBuffer) {
		for (var type in dataTypes) {
			if (!dataTypes.hasOwnProperty(type)) {
				continue;
			}

			var name;
			if (type === 'Int8' || type === 'Uint8') {
				name = 'read' + nodeNaming[type];
			} else if (littleEndian) {
				name = 'read' + nodeNaming[type] + 'LE';
			} else {
				name = 'read' + nodeNaming[type] + 'BE';
			}

			(function(type, view, name){
				var size = dataTypes[type];
				view['get' + type] = function (byteOffset, littleEndian) {
					// Handle the lack of endianness
					if (littleEndian === undefined) {
						littleEndian = view._littleEndian;
					}

					// Handle the lack of byteOffset
					if (byteOffset === undefined) {
						byteOffset = view._offset;
					}

					// Move the internal offset forward
					view._offset = byteOffset + size;

					return view.buffer[name](view._start + byteOffset);
				};
			})(type, this, name);
		}
	} else {
		for (var type in dataTypes) {
			if (!dataTypes.hasOwnProperty(type)) {
				continue;
			}
			(function(type, view){
				var size = dataTypes[type];
				view['get' + type] = function (byteOffset, littleEndian) {
					// Handle the lack of endianness
					if (littleEndian === undefined) {
						littleEndian = view._littleEndian;
					}

					// Handle the lack of byteOffset
					if (byteOffset === undefined) {
						byteOffset = view._offset;
					}

					// Move the internal offset forward
					view._offset = byteOffset + size;

					if (view._isArrayBuffer && (view._start + byteOffset) % size === 0 && (size === 1 || littleEndian)) {
						// ArrayBuffer: we use a typed array of size 1 if the alignment is good
						// ArrayBuffer does not support endianess flag (for size > 1)
						return new global[type + 'Array'](view.buffer, view._start + byteOffset, 1)[0];
					} else {
						// Error checking:
						if (typeof byteOffset !== 'number') {
							throw new TypeError('jDataView byteOffset is not a number');
						}
						if (byteOffset + size > view.byteLength) {
							throw new Error('jDataView (byteOffset + size) value is out of bounds');
						}

						return view['_get' + type](view._start + byteOffset, littleEndian);
					}
				};
			})(type, this);
		}
	}
};

if (compatibility.NodeBuffer) {
	jDataView.createBuffer = function () {
		return new Buffer(arguments);
	};
} else if (compatibility.ArrayBuffer) {
	jDataView.createBuffer = function () {
		return new Uint8Array(arguments).buffer;
	};
} else {
	jDataView.createBuffer = function () {
		return String.fromCharCode.apply(null, arguments);
	};
}

jDataView.prototype = {
	compatibility: compatibility,

	// Helpers

	_getBytes: function (length, byteOffset, littleEndian) {
		var result;

		// Handle the lack of endianness
		if (littleEndian === undefined) {
			littleEndian = this._littleEndian;
		}

		// Handle the lack of byteOffset
		if (byteOffset === undefined) {
			byteOffset = this._offset;
		}

		// Error Checking
		if (typeof byteOffset !== 'number') {
			throw new TypeError('jDataView byteOffset is not a number');
		}
		if (length < 0 || byteOffset + length > this.byteLength) {
			throw new Error('jDataView length or (byteOffset+length) value is out of bounds');
		}

		byteOffset += this._start;

		if (this._isArrayBuffer) {
			result = new Uint8Array(this.buffer, byteOffset, length);
		}
		else {
			result = this.buffer.slice(byteOffset, byteOffset + length);

			if (!this._isNodeBuffer) {
				result = Array.prototype.map.call(result, function (ch) {
					return ch.charCodeAt(0) & 0xff;
				});
			}
		}

		if (littleEndian && length > 1) {
			if (!(result instanceof Array)) {
				result = Array.prototype.slice.call(result);
			}

			result.reverse();
		}

		this._offset = byteOffset - this._start + length;

		return result;
	},

	// wrapper for external calls (do not return inner buffer directly to prevent it's modifying)
	getBytes: function (length, byteOffset, littleEndian) {
		var result = this._getBytes.apply(this, arguments);

		if (!(result instanceof Array)) {
			result = Array.prototype.slice.call(result);
		}

		return result;
	},

	getString: function (length, byteOffset) {
		var value;

		if (this._isNodeBuffer) {
			// Handle the lack of byteOffset
			if (byteOffset === undefined) {
				byteOffset = this._offset;
			}

			// Error Checking
			if (typeof byteOffset !== 'number') {
				throw new TypeError('jDataView byteOffset is not a number');
			}
			if (length < 0 || byteOffset + length > this.byteLength) {
				throw new Error('jDataView length or (byteOffset+length) value is out of bounds');
			}

			value = this.buffer.toString('ascii', this._start + byteOffset, this._start + byteOffset + length);
			this._offset = byteOffset + length;
		}
		else {
			value = String.fromCharCode.apply(null, this._getBytes(length, byteOffset, false));
		}

		return value;
	},

	getChar: function (byteOffset) {
		return this.getString(1, byteOffset);
	},

	tell: function () {
		return this._offset;
	},

	seek: function (byteOffset) {
		if (typeof byteOffset !== 'number') {
			throw new TypeError('jDataView byteOffset is not a number');
		}
		if (byteOffset < 0 || byteOffset > this.byteLength) {
			throw new Error('jDataView byteOffset value is out of bounds');
		}

		return this._offset = byteOffset;
	},

	// Compatibility functions on a String Buffer

	_getFloat64: function (byteOffset, littleEndian) {
		var b = this._getBytes(8, byteOffset, littleEndian),

			sign = 1 - (2 * (b[0] >> 7)),
			exponent = ((((b[0] << 1) & 0xff) << 3) | (b[1] >> 4)) - (Math.pow(2, 10) - 1),

		// Binary operators such as | and << operate on 32 bit values, using + and Math.pow(2) instead
			mantissa = ((b[1] & 0x0f) * Math.pow(2, 48)) + (b[2] * Math.pow(2, 40)) + (b[3] * Math.pow(2, 32)) +
						(b[4] * Math.pow(2, 24)) + (b[5] * Math.pow(2, 16)) + (b[6] * Math.pow(2, 8)) + b[7];

		if (exponent === 1024) {
			if (mantissa !== 0) {
				return NaN;
			} else {
				return sign * Infinity;
			}
		}

		if (exponent === -1023) { // Denormalized
			return sign * mantissa * Math.pow(2, -1022 - 52);
		}

		return sign * (1 + mantissa * Math.pow(2, -52)) * Math.pow(2, exponent);
	},

	_getFloat32: function (byteOffset, littleEndian) {
		var b = this._getBytes(4, byteOffset, littleEndian),

			sign = 1 - (2 * (b[0] >> 7)),
			exponent = (((b[0] << 1) & 0xff) | (b[1] >> 7)) - 127,
			mantissa = ((b[1] & 0x7f) << 16) | (b[2] << 8) | b[3];

		if (exponent === 128) {
			if (mantissa !== 0) {
				return NaN;
			} else {
				return sign * Infinity;
			}
		}

		if (exponent === -127) { // Denormalized
			return sign * mantissa * Math.pow(2, -126 - 23);
		}

		return sign * (1 + mantissa * Math.pow(2, -23)) * Math.pow(2, exponent);
	},

	_getInt32: function (byteOffset, littleEndian) {
		var b = this._getUint32(byteOffset, littleEndian);
		return b > Math.pow(2, 31) - 1 ? b - Math.pow(2, 32) : b;
	},

	_getUint32: function (byteOffset, littleEndian) {
		var b = this._getBytes(4, byteOffset, littleEndian);
		return (b[0] * Math.pow(2, 24)) + (b[1] << 16) + (b[2] << 8) + b[3];
	},

	_getInt16: function (byteOffset, littleEndian) {
		var b = this._getUint16(byteOffset, littleEndian);
		return b > Math.pow(2, 15) - 1 ? b - Math.pow(2, 16) : b;
	},

	_getUint16: function (byteOffset, littleEndian) {
		var b = this._getBytes(2, byteOffset, littleEndian);
		return (b[0] << 8) + b[1];
	},

	_getInt8: function (byteOffset) {
		var b = this._getUint8(byteOffset);
		return b > Math.pow(2, 7) - 1 ? b - Math.pow(2, 8) : b;
	},

	_getUint8: function (byteOffset) {
		return this._getBytes(1, byteOffset)[0];
	}
};

if (typeof jQuery !== 'undefined' && jQuery.fn.jquery >= "1.6.2") {
	var convertResponseBodyToText = function (byteArray) {
		// http://jsperf.com/vbscript-binary-download/6
		var scrambledStr;
		try {
			scrambledStr = IEBinaryToArray_ByteStr(byteArray);
		} catch (e) {
			// http://stackoverflow.com/questions/1919972/how-do-i-access-xhr-responsebody-for-binary-data-from-javascript-in-ie
			// http://miskun.com/javascript/internet-explorer-and-binary-files-data-access/
			var IEBinaryToArray_ByteStr_Script =
				"Function IEBinaryToArray_ByteStr(Binary)\r\n"+
				"	IEBinaryToArray_ByteStr = CStr(Binary)\r\n"+
				"End Function\r\n"+
				"Function IEBinaryToArray_ByteStr_Last(Binary)\r\n"+
				"	Dim lastIndex\r\n"+
				"	lastIndex = LenB(Binary)\r\n"+
				"	if lastIndex mod 2 Then\r\n"+
				"		IEBinaryToArray_ByteStr_Last = AscB( MidB( Binary, lastIndex, 1 ) )\r\n"+
				"	Else\r\n"+
				"		IEBinaryToArray_ByteStr_Last = -1\r\n"+
				"	End If\r\n"+
				"End Function\r\n";

			// http://msdn.microsoft.com/en-us/library/ms536420(v=vs.85).aspx
			// proprietary IE function
			window.execScript(IEBinaryToArray_ByteStr_Script, 'vbscript');

			scrambledStr = IEBinaryToArray_ByteStr(byteArray);
		}

		var lastChr = IEBinaryToArray_ByteStr_Last(byteArray),
		result = "",
		i = 0,
		l = scrambledStr.length % 8,
		thischar;
		while (i < l) {
			thischar = scrambledStr.charCodeAt(i++);
			result += String.fromCharCode(thischar & 0xff, thischar >> 8);
		}
		l = scrambledStr.length;
		while (i < l) {
			result += String.fromCharCode(
				(thischar = scrambledStr.charCodeAt(i++), thischar & 0xff), thischar >> 8,
				(thischar = scrambledStr.charCodeAt(i++), thischar & 0xff), thischar >> 8,
				(thischar = scrambledStr.charCodeAt(i++), thischar & 0xff), thischar >> 8,
				(thischar = scrambledStr.charCodeAt(i++), thischar & 0xff), thischar >> 8,
				(thischar = scrambledStr.charCodeAt(i++), thischar & 0xff), thischar >> 8,
				(thischar = scrambledStr.charCodeAt(i++), thischar & 0xff), thischar >> 8,
				(thischar = scrambledStr.charCodeAt(i++), thischar & 0xff), thischar >> 8,
				(thischar = scrambledStr.charCodeAt(i++), thischar & 0xff), thischar >> 8);
		}
		if (lastChr > -1) {
			result += String.fromCharCode(lastChr);
		}
		return result;
	};

	jQuery.ajaxSetup({
		converters: {
			'* dataview': function(data) {
				return new jDataView(data);
			}
		},
		accepts: {
			dataview: "text/plain; charset=x-user-defined"
		},
		responseHandler: {
			dataview: function (responses, options, xhr) {
				// Array Buffer Firefox
				if ('mozResponseArrayBuffer' in xhr) {
					responses.text = xhr.mozResponseArrayBuffer;
				}
				// Array Buffer Chrome
				else if ('responseType' in xhr && xhr.responseType === 'arraybuffer' && xhr.response) {
					responses.text = xhr.response;
				}
				// Internet Explorer (Byte array accessible through VBScript -- convert to text)
				else if ('responseBody' in xhr) {
					responses.text = convertResponseBodyToText(xhr.responseBody);
				}
				// Older Browsers
				else {
					responses.text = xhr.responseText;
				}
			}
		}
	});

	jQuery.ajaxPrefilter('dataview', function(options, originalOptions, jqXHR) {
		// trying to set the responseType on IE 6 causes an error
		if (jQuery.support.ajaxResponseType) {
			if (!options.hasOwnProperty('xhrFields')) {
				options.xhrFields = {};
			}
			options.xhrFields.responseType = 'arraybuffer';
		}
		options.mimeType = 'text/plain; charset=x-user-defined';
	});
}

global.jDataView = (global.module || {}).exports = jDataView;
if (typeof module !== 'undefined') {
	module.exports = jDataView;
}

})(scope);

return scope.jDataView;
});
},
'JBrowse/Store/SeqFeature/BigWig/Window':function(){
define( [
            'dojo/_base/declare',
            'dojo/_base/lang',
            'dojo/_base/array',
            './RequestWorker'
        ],
        function( declare, lang, array, RequestWorker ) {

var dlog = function(){ console.log.apply(console, arguments); };

return declare( null,
 /**
  * @lends JBrowse.Store.BigWig.Window.prototype
  */
{

    /**
     * View into a subset of the data in a BigWig file.
     *
     * Adapted by Robert Buels from bigwig.js in the Dalliance Genome
     * Explorer by Thomas Down.
     * @constructs
     */
    constructor: function(bwg, cirTreeOffset, cirTreeLength, isSummary) {
        this.bwg = bwg;
        if( !( cirTreeOffset >= 0 ) )
            throw "invalid cirTreeOffset!";
        if( !( cirTreeLength > 0 ) )
            throw "invalid cirTreeLength!";

        this.cirTreeOffset = cirTreeOffset;
        this.cirTreeLength = cirTreeLength;
        this.isSummary = isSummary;
    },

    BED_COLOR_REGEXP: /^[0-9]+,[0-9]+,[0-9]+/,

    readWigData: function(chrName, min, max, callback, errorCallback ) {
        // console.log( 'reading wig data from '+chrName+':'+min+'..'+max);
        var chr = this.bwg.refsByName[chrName];
        if ( ! chr ) {
            // Not an error because some .bwgs won't have data for all chromosomes.

            // dlog("Couldn't find chr " + chrName);
            // dlog('Chroms=' + miniJSONify(this.bwg.refsByName));
            callback([]);
        } else {
            this.readWigDataById( chr.id, min, max, callback, errorCallback );
        }
    },

    readWigDataById: function(chr, min, max, callback, errorCallback ) {
        if( !this.cirHeader ) {
            var readCallback = lang.hitch( this, 'readWigDataById', chr, min, max, callback, errorCallback );
            if( this.cirHeaderLoading ) {
                this.cirHeaderLoading.push( readCallback );
            }
            else {
                this.cirHeaderLoading = [ readCallback ];
                // dlog('No CIR yet, fetching');
                this.bwg.data
                    .read( this.cirTreeOffset, 48, lang.hitch( this, function(result) {
                                this.cirHeader = result;
                                this.cirBlockSize = this.bwg.newDataView( result, 4, 4 ).getUint32();
                                array.forEach( this.cirHeaderLoading, function(c) { c(); });
                                delete this.cirHeaderLoading;
                            }), errorCallback );
            }
            return;
        }

        //dlog('_readWigDataById', chr, min, max, callback);

        var worker = new RequestWorker( this, chr, min, max, callback, errorCallback );
        worker.cirFobRecur([this.cirTreeOffset + 48], 1);
    }
});

});

},
'JBrowse/Store/SeqFeature/BigWig/RequestWorker':function(){
define( [
            'dojo/_base/declare',
            'dojo/_base/lang',
            'dojo/_base/array',
            'JBrowse/Util',
            'JBrowse/Util/RejectableFastPromise',
            'dojo/promise/all',
            'JBrowse/Model/Range',
            'JBrowse/Model/SimpleFeature',
            'jszlib/inflate',
            'jszlib/arrayCopy'
        ],
        function(
            declare,
            dlang,
            array,
            Util,
            RejectableFastPromise,
            all,
            Range,
            SimpleFeature,
            inflate,
            arrayCopy
        ) {

var dlog = function(){ console.log.apply(console, arguments); };

var RequestWorker = declare( null,
 /**
  * @lends JBrowse.Store.BigWig.Window.RequestWorker.prototype
  */
 {

    BIG_WIG_TYPE_GRAPH: 1,
    BIG_WIG_TYPE_VSTEP: 2,
    BIG_WIG_TYPE_FSTEP: 3,

    /**
     * Worker object for reading data from a bigwig or bigbed file.
     * Manages the state necessary for traversing the index trees and
     * so forth.
     *
     * Adapted by Robert Buels from bigwig.js in the Dalliance Genome
     * Explorer by Thomas Down.
     * @constructs
     */
    constructor: function( window, chr, min, max, callback, errorCallback ) {
        this.window = window;
        this.source = window.bwg.name || undefined;

        this.blocksToFetch = [];
        this.outstanding = 0;

        this.chr = chr;
        this.min = min;
        this.max = max;
        this.callback = callback;
        this.errorCallback = errorCallback || function(e) { console.error( e, e.stack, arguments.caller ); };
    },

    cirFobRecur: function(offset, level) {
        this.outstanding += offset.length;

        var maxCirBlockSpan = 4 +  (this.window.cirBlockSize * 32);   // Upper bound on size, based on a completely full leaf node.
        var spans;
        for (var i = 0; i < offset.length; ++i) {
            var blockSpan = new Range(offset[i], Math.min(offset[i] + maxCirBlockSpan, this.window.cirTreeOffset + this.window.cirTreeLength));
            spans = spans ? spans.union( blockSpan ) : blockSpan;
        }

        var fetchRanges = spans.ranges();
        //dlog('fetchRanges: ' + fetchRanges);
        for (var r = 0; r < fetchRanges.length; ++r) {
            var fr = fetchRanges[r];
            this.cirFobStartFetch(offset, fr, level);
        }
    },

    cirFobStartFetch: function(offset, fr, level, attempts) {
        var length = fr.max() - fr.min();
        // dlog('fetching ' + fr.min() + '-' + fr.max() + ' (' + Util.humanReadableNumber(length) + ')');
        //console.log('cirfobstartfetch');
        this.window.bwg._read( fr.min(), length, dlang.hitch( this,function(resultBuffer) {
                for (var i = 0; i < offset.length; ++i) {
                        if (fr.contains(offset[i])) {
                            this.cirFobRecur2(resultBuffer, offset[i] - fr.min(), level);
                            --this.outstanding;
                            if (this.outstanding == 0) {
                                this.cirCompleted();
                            }
                        }
                    }
             }), this.errorCallback );
    },

    cirFobRecur2: function(cirBlockData, offset, level) {
        var data = this.window.bwg.newDataView( cirBlockData, offset );

        var isLeaf = data.getUint8();
        var cnt = data.getUint16( 2 );
        //dlog('cir level=' + level + '; cnt=' + cnt);

        if (isLeaf != 0) {
            for (var i = 0; i < cnt; ++i) {
                var startChrom = data.getUint32();
                var startBase = data.getUint32();
                var endChrom = data.getUint32();
                var endBase = data.getUint32();
                var blockOffset = data.getUint64();
                var blockSize   = data.getUint64();
                if ((startChrom < this.chr || (startChrom == this.chr && startBase <= this.max)) &&
                    (endChrom   > this.chr || (endChrom == this.chr && endBase >= this.min)))
                {
                    // dlog('Got an interesting block: startBase=' + startBase + '; endBase=' + endBase + '; offset=' + blockOffset + '; size=' + blockSize);
                    this.blocksToFetch.push({offset: blockOffset, size: blockSize});
                }
            }
        } else {
            var recurOffsets = [];
            for (var i = 0; i < cnt; ++i) {
                var startChrom = data.getUint32();
                var startBase = data.getUint32();
                var endChrom = data.getUint32();
                var endBase = data.getUint32();
                var blockOffset = data.getUint64();
                if ((startChrom < this.chr || (startChrom == this.chr && startBase <= this.max)) &&
                    (endChrom   > this.chr || (endChrom == this.chr && endBase >= this.min)))
                {
                    recurOffsets.push(blockOffset);
                }
            }
            if (recurOffsets.length > 0) {
                this.cirFobRecur(recurOffsets, level + 1);
            }
        }
    },

    cirCompleted: function() {
        // merge contiguous blocks
        this.blockGroupsToFetch = this.groupBlocks( this.blocksToFetch );

        if (this.blockGroupsToFetch.length == 0) {
            this.callback([]);
        } else {
            this.features = [];
            this.readFeatures();
        }
    },


    groupBlocks: function( blocks ) {

        // sort the blocks by file offset
        blocks.sort(function(b0, b1) {
                        return (b0.offset|0) - (b1.offset|0);
                    });

        // group blocks that are within 2KB of eachother
        var blockGroups = [];
        var lastBlock;
        var lastBlockEnd;
        for( var i = 0; i<blocks.length; i++ ) {
            if( lastBlock && (blocks[i].offset-lastBlockEnd) <= 2000 ) {
                lastBlock.size += blocks[i].size - lastBlockEnd + blocks[i].offset;
                lastBlock.blocks.push( blocks[i] );
            }
            else {
                blockGroups.push( lastBlock = { blocks: [blocks[i]], size: blocks[i].size, offset: blocks[i].offset } );
            }
            lastBlockEnd = lastBlock.offset + lastBlock.size;
        }

        return blockGroups;
    },

    createFeature: function(fmin, fmax, opts) {
        // dlog('createFeature(' + fmin +', ' + fmax + ', '+opts.score+')');

        var data = { start: fmin,
                     end: fmax,
                     source: this.source
                   };

        for( var k in opts )
            data[k] = opts[k];

        var f = new SimpleFeature({
            data: data
        });

        this.features.push(f);
    },

    maybeCreateFeature: function(fmin, fmax, opts) {
        if (fmin <= this.max && fmax >= this.min) {
            this.createFeature( fmin, fmax, opts );
        }
    },

    parseSummaryBlock: function( bytes, startOffset ) {
        var data = this.window.bwg.newDataView( bytes, startOffset );

        var itemCount = bytes.byteLength/32;
        for (var i = 0; i < itemCount; ++i) {
            var chromId =   data.getInt32();
            var start =     data.getInt32();
            var end =       data.getInt32();
            var validCnt =  data.getInt32()||1;
            var minVal    = data.getFloat32();
            var maxVal    = data.getFloat32();
            var sumData   = data.getFloat32();
            var sumSqData = data.getFloat32();

            if (chromId == this.chr) {
                var summaryOpts = {score: sumData/validCnt,maxScore: maxVal,minScore:minVal};
                if (this.window.bwg.type == 'bigbed') {
                    summaryOpts.type = 'density';
                }
                this.maybeCreateFeature( start, end, summaryOpts);
            }
        }
    },

    parseBigWigBlock: function( bytes, startOffset ) {
        var data = this.window.bwg.newDataView( bytes, startOffset );

        var itemSpan = data.getUint32( 16 );
        var blockType = data.getUint8( 20 );
        var itemCount = data.getUint16( 22 );

        // dlog('processing bigwig block, type=' + blockType + '; count=' + itemCount);

        if (blockType == this.BIG_WIG_TYPE_FSTEP) {
            var blockStart = data.getInt32( 4 );
            var itemStep = data.getUint32( 12 );
            for (var i = 0; i < itemCount; ++i) {
                var score = data.getFloat32( 4*i+24 );
                this.maybeCreateFeature( blockStart + (i*itemStep), blockStart + (i*itemStep) + itemSpan, {score: score});
            }
        } else if (blockType == this.BIG_WIG_TYPE_VSTEP) {
            for (var i = 0; i < itemCount; ++i) {
                var start = data.getInt32( 8*i+24 );
                var score = data.getFloat32();
                this.maybeCreateFeature( start, start + itemSpan, {score: score});
            }
        } else if (blockType == this.BIG_WIG_TYPE_GRAPH) {
            for (var i = 0; i < itemCount; ++i) {
                var start = data.getInt32( 12*i + 24 );
                var end   = data.getInt32();
                var score = data.getFloat32();
                if (start > end) {
                    start = end;
                }
                this.maybeCreateFeature( start, end, {score: score});
            }
        } else {
            dlog('Currently not handling bwgType=' + blockType);
        }
    },

    parseBigBedBlock: function( bytes, startOffset ) {
        var data = this.window.bwg.newDataView( bytes, startOffset );

        var offset = 0;
        while (offset < bytes.length) {
            var chromId = data.getUint32( offset );
            var start = data.getInt32( offset+4 );
            var end = data.getInt32( offset+8 );
            offset += 12;
            var rest = '';
            while( offset < bytes.length ) {
                var ch = data.getUint8( offset++ );
                if (ch != 0) {
                    rest += String.fromCharCode(ch);
                } else {
                    break;
                }
            }

            var featureOpts = {};

            var bedColumns = rest.split('\t');
            if (bedColumns.length > 0) {
                featureOpts.label = bedColumns[0];
            }
            if (bedColumns.length > 1) {
                featureOpts.score = parseInt( bedColumns[1] );
            }
            if (bedColumns.length > 2) {
                featureOpts.orientation = bedColumns[2];
            }
            if (bedColumns.length > 5) {
                var color = bedColumns[5];
                if (this.window.BED_COLOR_REGEXP.test(color)) {
                    featureOpts.override_color = 'rgb(' + color + ')';
                }
            }

            if (bedColumns.length < 9) {
                if (chromId == this.chr) {
                    this.maybeCreateFeature( start, end, featureOpts);
                }
            } else if (chromId == this.chr && start <= this.max && end >= this.min) {
                // Complex-BED?
                // FIXME this is currently a bit of a hack to do Clever Things with ensGene.bb

                var thickStart = bedColumns[3]|0;
                var thickEnd   = bedColumns[4]|0;
                var blockCount = bedColumns[6]|0;
                var blockSizes = bedColumns[7].split(',');
                var blockStarts = bedColumns[8].split(',');

                featureOpts.type = 'bb-transcript';
                var grp = new Feature();
                grp.id = bedColumns[0];
                grp.type = 'bb-transcript';
                grp.notes = [];
                featureOpts.groups = [grp];

                if (bedColumns.length > 10) {
                    var geneId = bedColumns[9];
                    var geneName = bedColumns[10];
                    var gg = new Feature();
                    gg.id = geneId;
                    gg.label = geneName;
                    gg.type = 'gene';
                    featureOpts.groups.push(gg);
                }

                var spans = null;
                for (var b = 0; b < blockCount; ++b) {
                    var bmin = (blockStarts[b]|0) + start;
                    var bmax = bmin + (blockSizes[b]|0);
                    var span = new Range(bmin, bmax);
                    if (spans) {
                        spans = spans.union( span );
                    } else {
                        spans = span;
                    }
                }

                var tsList = spans.ranges();
                for (var s = 0; s < tsList.length; ++s) {
                    var ts = tsList[s];
                    this.createFeature( ts.min(), ts.max(), featureOpts);
                }

                if (thickEnd > thickStart) {
                    var tl = spans.intersection( new Range(thickStart, thickEnd) );
                    if (tl) {
                        featureOpts.type = 'bb-translation';
                        var tlList = tl.ranges();
                        for (var s = 0; s < tlList.length; ++s) {
                            var ts = tlList[s];
                            this.createFeature( ts.min(), ts.max(), featureOpts);
                        }
                    }
                }
            }
        }
    },

    readFeatures: function() {
        var thisB = this;
        var blockFetches = array.map( thisB.blockGroupsToFetch, function( blockGroup ) {
            //console.log( 'fetching blockgroup with '+blockGroup.blocks.length+' blocks: '+blockGroup );
            var d = new RejectableFastPromise();
            thisB.window.bwg._read( blockGroup.offset, blockGroup.size, function( data ) {
                            blockGroup.data = data;
                            d.resolve( blockGroup );
                        }, dlang.hitch( d, 'reject' ) );
            return d;
        }, thisB );

        all( blockFetches ).then( function( blockGroups ) {
            array.forEach( blockGroups, function( blockGroup ) {
                array.forEach( blockGroup.blocks, function( block ) {
                                   var data;
                                   var offset = block.offset - blockGroup.offset;
                                   if( thisB.window.bwg.uncompressBufSize > 0 ) {
                                       // var beforeInf = new Date();
                                       data = inflate( blockGroup.data, offset+2, block.size - 2);
                                       offset = 0;
                                       //console.log( 'inflate', 2, block.size - 2);
                                       // var afterInf = new Date();
                                       // dlog('inflate: ' + (afterInf - beforeInf) + 'ms');
                                   } else {
                                       data = blockGroup.data;
                                   }

                                   if( thisB.window.isSummary ) {
                                       thisB.parseSummaryBlock( data, offset );
                                   } else if (thisB.window.bwg.type == 'bigwig') {
                                       thisB.parseBigWigBlock( data, offset );
                                   } else if (thisB.window.bwg.type == 'bigbed') {
                                       thisB.parseBigBedBlock( data, offset );
                                   } else {
                                       dlog("Don't know what to do with " + thisB.window.bwg.type);
                                   }
                });
            });

            thisB.callback( thisB.features );
       }, thisB.errorCallback );
    }
});

return RequestWorker;

});

},
'JBrowse/Util/RejectableFastPromise':function(){
/**
 * Fast implementation of a promise, used in performance-critical code
 * that still needs to be able to reject promises.  Dojo Deferred is
 * too heavy for some uses.
 */

define([
       ],
       function(
       ) {

var fastpromise = function() {
    this.callbacks = [];
    this.errbacks = [];
};

fastpromise.prototype.then = function( callback, errback ) {
    if( 'value' in this )
        callback( this.value );
    else if( 'error' in this )
        errback( this.error );
    else {
        this.callbacks.push( callback );
        this.errbacks.push( errback );
    }
};

fastpromise.prototype.resolve = function( value ) {
    this.value = value;
    delete this.errbacks;
    var c = this.callbacks;
    delete this.callbacks;
    for( var i = 0; i<c.length; i++ )
        c[i]( this.value );
};

fastpromise.prototype.reject = function( error ) {
    this.error = error;
    delete this.callbacks;
    var c = this.errbacks;
    delete this.errbacks;
    for( var i = 0; i<c.length; i++ )
        c[i]( error );
};

return fastpromise;
});
},
'JBrowse/Model/Range':function(){
define( "JBrowse/Model/Range", [
            'dojo/_base/declare'
        ],
        function( declare ) {

var Range = declare( null,
/**
 * @lends JBrowse.Model.Range.prototype
 */
{

    /**
     * Adapted from a combination of Range and _Compound in the
     * Dalliance Genome Explorer, (c) Thomas Down 2006-2010.
     */
    constructor: function() {
        this._ranges =
            arguments.length == 2 ? [ { min: arguments[0], max: arguments[1] } ] :
            0 in arguments[0]     ? dojo.clone( arguments[0] )                   :
                                    [ arguments[0] ];
    },

    min: function() {
        return this._ranges[0].min;
    },

    max: function() {
        return this._ranges[this._ranges.length - 1].max;
    },

    contains: function(pos) {
        for (var s = 0; s < this._ranges.length; ++s) {
            var r = this._ranges[s];
            if ( r.min <= pos && r.max >= pos ) {
                return true;
            }
        }
        return false;
    },

    isContiguous: function() {
        return this._ranges.length > 1;
    },

    ranges: function() {
        return this._ranges.map( function(r) {
            return new Range( r.min, r.max );
        });
    },

    toString: function() {
        return this._ranges
            .map(function(r) { return '['+r.min+'-'+r.max+']'; })
            .join(',');
    },

    union: function(s1) {
        var s0 = this;
        var ranges = s0.ranges().concat(s1.ranges()).sort( this.rangeOrder );
        var oranges = [];
        var current = ranges[0];

        for (var i = 1; i < ranges.length; ++i) {
            var nxt = ranges[i];
            if (nxt.min() > (current.max() + 1)) {
                oranges.push(current);
                current = nxt;
            } else {
                if (nxt.max() > current.max()) {
                    current = new Range(current.min(), nxt.max());
                }
            }
        }
        oranges.push(current);

        if (oranges.length == 1) {
            return oranges[0];
        } else {
            return new _Compound(oranges);
        }
    },

    intersection: function( s1 ) {
        var s0 = this;
        var r0 = s0.ranges();
        var r1 = s1.ranges();
        var l0 = r0.length, l1 = r1.length;
        var i0 = 0, i1 = 0;
        var or = [];

        while (i0 < l0 && i1 < l1) {
            var s0 = r0[i0], s1 = r1[i1];
            var lapMin = Math.max(s0.min(), s1.min());
            var lapMax = Math.min(s0.max(), s1.max());
            if (lapMax >= lapMin) {
                or.push(new Range(lapMin, lapMax));
            }
            if (s0.max() > s1.max()) {
                ++i1;
            } else {
                ++i0;
            }
        }

        if (or.length == 0) {
            return null; // FIXME
        } else if (or.length == 1) {
            return or[0];
        } else {
            return new _Compound(or);
        }
    },

    coverage: function() {
        var tot = 0;
        var rl = this.ranges();
        for (var ri = 0; ri < rl.length; ++ri) {
            var r = rl[ri];
            tot += (r.max() - r.min() + 1);
        }
        return tot;
    },

    rangeOrder: function( a, b ) {
        if( arguments.length < 2 ) {
            b = a;
            a = this;
        }

        if (a.min() < b.min()) {
            return -1;
        } else if (a.min() > b.min()) {
            return 1;
        } else if (a.max() < b.max()) {
            return -1;
        } else if (b.max() > a.max()) {
            return 1;
        } else {
            return 0;
        }
    }
});

return Range;
});


}}});
define( "JBrowse/Store/SeqFeature/BigWig", [
            'dojo/_base/declare',
            'dojo/_base/lang',
            'dojo/_base/array',
            'dojo/_base/url',
            'JBrowse/Model/DataView',
            'JBrowse/has',
            'JBrowse/Errors',
            'JBrowse/Store/SeqFeature',
            'JBrowse/Store/DeferredStatsMixin',
            'JBrowse/Store/DeferredFeaturesMixin',
            './BigWig/Window',
            'JBrowse/Util',
            'JBrowse/Model/XHRBlob'
        ],
        function(
            declare,
            lang,
            array,
            urlObj,
            jDataView,
            has,
            JBrowseErrors,
            SeqFeatureStore,
            DeferredFeaturesMixin,
            DeferredStatsMixin,
            Window,
            Util,
            XHRBlob
        ) {
return declare([ SeqFeatureStore, DeferredFeaturesMixin, DeferredStatsMixin ],

 /**
  * @lends JBrowse.Store.BigWig
  */
{

    BIG_WIG_MAGIC: -2003829722,
    BIG_BED_MAGIC: -2021002517,

    BIG_WIG_TYPE_GRAPH: 1,
    BIG_WIG_TYPE_VSTEP: 2,
    BIG_WIG_TYPE_FSTEP: 3,

    _littleEndian: true,

    /**
     * Data backend for reading wiggle data from BigWig or BigBed files.
     *
     * Adapted by Robert Buels from bigwig.js in the Dalliance Genome
     * Explorer which is copyright Thomas Down 2006-2010
     * @constructs
     */
    constructor: function( args ) {

        this.data = args.blob ||
            new XHRBlob( this.resolveUrl(
                             args.urlTemplate || 'data.bigwig'
                         )
                       );

        this.name = args.name || ( this.data.url && new urlObj( this.data.url ).path.replace(/^.+\//,'') ) || 'anonymous';

        this._load();
    },

    _defaultConfig: function() {
        return Util.deepUpdate(
            dojo.clone( this.inherited(arguments) ),
            {
                chunkSizeLimit: 30000000 // 30mb
            });
    },

    _getGlobalStats: function( successCallback, errorCallback ) {
        var s = this._globalStats || {};

        // calc mean and standard deviation if necessary
        if( !( 'scoreMean' in s ))
            s.scoreMean = s.basesCovered ? s.scoreSum / s.basesCovered : 0;
        if( !( 'scoreStdDev' in s ))
            s.scoreStdDev = this._calcStdFromSums( s.scoreSum, s.scoreSumSquares, s.basesCovered );

        successCallback( s );
    },

     /**
      * Read from the bbi file, respecting the configured chunkSizeLimit.
      */
    _read: function( start, size, callback, errorcallback ) {
        if( size > this.config.chunkSizeLimit )
            errorcallback( new JBrowseErrors.DataOverflow('Too much data. Chunk size '+Util.commifyNumber(size)+' bytes exceeds chunkSizeLimit of '+Util.commifyNumber(this.config.chunkSizeLimit)+'.' ) );
        else
            this.data.read.apply( this.data, arguments );
    },

    _load: function() {
        this._read( 0, 512, lang.hitch( this, function( bytes ) {
            if( ! bytes ) {
                this._failAllDeferred( 'BBI header not readable' );
                return;
            }

            var data = this.newDataView( bytes );

            // check magic numbers
            var magic = data.getInt32();
            if( magic != this.BIG_WIG_MAGIC && magic != this.BIG_BED_MAGIC ) {
                // try the other endianness if no magic
                this._littleEndian = false;
                data = this.newDataView( bytes );
                if( data.getInt32() != this.BIG_WIG_MAGIC && magic != this.BIG_BED_MAGIC) {
                    console.error('Not a BigWig or BigBed file');
                    deferred.reject('Not a BigWig or BigBed file');
                    return;
                }
            }
            this.type = magic == this.BIG_BED_MAGIC ? 'bigbed' : 'bigwig';

            this.fileSize = bytes.fileSize;
            if( ! this.fileSize )
                console.warn("cannot get size of BigWig/BigBed file, widest zoom level not available");

            this.version = data.getUint16();
            this.numZoomLevels = data.getUint16();
            this.chromTreeOffset = data.getUint64();
            this.unzoomedDataOffset = data.getUint64();
            this.unzoomedIndexOffset = data.getUint64();
            this.fieldCount = data.getUint16();
            this.definedFieldCount = data.getUint16();
            this.asOffset = data.getUint64();
            this.totalSummaryOffset = data.getUint64();
            this.uncompressBufSize = data.getUint32();

            // dlog('bigType: ' + this.type);
            // dlog('chromTree at: ' + this.chromTreeOffset);
            // dlog('uncompress: ' + this.uncompressBufSize);
            // dlog('data at: ' + this.unzoomedDataOffset);
            // dlog('index at: ' + this.unzoomedIndexOffset);
            // dlog('field count: ' + this.fieldCount);
            // dlog('defined count: ' + this.definedFieldCount);

            this.zoomLevels = [];
            for (var zl = 0; zl < this.numZoomLevels; ++zl) {
                var zlReduction = data.getUint32( 4*(zl*6 + 16) );
                var zlData = data.getUint64( 4*(zl*6 + 18) );
                var zlIndex = data.getUint64( 4*(zl*6 + 20) );

                //          dlog('zoom(' + zl + '): reduction=' + zlReduction + '; data=' + zlData + '; index=' + zlIndex);
                this.zoomLevels.push({reductionLevel: zlReduction, dataOffset: zlData, indexOffset: zlIndex});
            }

            // parse the totalSummary if present (summary of all data in the file)
            if( this.totalSummaryOffset ) {
                (function() {
                     var d = this.newDataView( bytes, this.totalSummaryOffset );
                     var s = {
                         basesCovered: d.getUint64(),
                         scoreMin: d.getFloat64(),
                         scoreMax: d.getFloat64(),
                         scoreSum: d.getFloat64(),
                         scoreSumSquares: d.getFloat64()
                     };
                     this._globalStats = s;
                     // rest of stats will be calculated on demand in getGlobalStats
                 }).call(this);
            } else {
                    console.warn("BigWig "+this.data.url+ " has no total summary data.");
            }

            this._readChromTree(
                function() {
                    this._deferred.features.resolve({success: true});
                    this._deferred.stats.resolve({success: true});
                },
                lang.hitch( this, '_failAllDeferred' )
            );
        }),
        lang.hitch( this, '_failAllDeferred' )
       );
    },

    newDataView: function( bytes, offset, length ) {
        return new jDataView( bytes, offset, length, this._littleEndian );
    },

    /**
     * @private
     */
    _readChromTree: function( callback, errorCallback ) {
        var thisB = this;
        this.refsByNumber = {};
        this.refsByName = {};

        var udo = this.unzoomedDataOffset;
        while ((udo % 4) != 0) {
            ++udo;
        }

        this._read( this.chromTreeOffset, udo - this.chromTreeOffset, function(bpt) {
                       if( ! has('typed-arrays') ) {
                           thisB._failAllDeferred( 'Web browser does not support typed arrays' );
                           return;
                       }
                       var data = thisB.newDataView( bpt );

                       if( data.getUint32() !== 2026540177 )
                           throw "parse error: not a Kent bPlusTree";
                       var blockSize = data.getUint32();
                       var keySize = data.getUint32();
                       var valSize = data.getUint32();
                       var itemCount = data.getUint64();
                       var rootNodeOffset = 32;

                       //dlog('blockSize=' + blockSize + '    keySize=' + keySize + '   valSize=' + valSize + '    itemCount=' + itemCount);

                       var bptReadNode = function(offset) {
                           if( offset >= bpt.length )
                               throw "reading beyond end of buffer";
                           var isLeafNode = data.getUint8( offset );
                           var cnt = data.getUint16( offset+2 );
                           //dlog('ReadNode: ' + offset + '     type=' + isLeafNode + '   count=' + cnt);
                           offset += 4;
                           for (var n = 0; n < cnt; ++n) {
                               if( isLeafNode ) {
                                   // parse leaf node
                                   var key = '';
                                   for (var ki = 0; ki < keySize; ++ki) {
                                       var charCode = data.getUint8( offset++ );
                                       if (charCode != 0) {
                                           key += String.fromCharCode(charCode);
                                       }
                                   }
                                   var refId = data.getUint32( offset );
                                   var refSize = data.getUint32( offset+4 );
                                   offset += 8;

                                   var refRec = { name: key, id: refId, length: refSize };

                                   //dlog(key + ':' + refId + ',' + refSize);
                                   thisB.refsByName[ thisB.browser.regularizeReferenceName(key) ] = refRec;
                                   thisB.refsByNumber[refId] = refRec;
                               } else {
                                   // parse index node
                                   offset += keySize;
                                   var childOffset = data.getUint64( offset );
                                   offset += 8;
                                   childOffset -= thisB.chromTreeOffset;
                                   bptReadNode(childOffset);
                               }
                           }
                       };
                       bptReadNode(rootNodeOffset);

                       callback.call( thisB, thisB );
            }, errorCallback );
    },

    /**
     * Interrogate whether a store has data for a given reference
     * sequence.  Calls the given callback with either true or false.
     *
     * Implemented as a binary interrogation because some stores are
     * smart enough to regularize reference sequence names, while
     * others are not.
     */
    hasRefSeq: function( seqName, callback, errorCallback ) {
        var thisB = this;
        seqName = thisB.browser.regularizeReferenceName( seqName );
        this._deferred.features.then(function() {
            callback( seqName in thisB.refsByName );
        }, errorCallback );
    },

    _getFeatures: function( query, featureCallback, endCallback, errorCallback ) {

        var chrName = this.browser.regularizeReferenceName( query.ref );
        var min = query.start;
        var max = query.end;

        var v = query.basesPerSpan ? this.getView( 1/query.basesPerSpan ) :
                       query.scale ? this.getView( query.scale )          :
                                     this.getView( 1 );

        if( !v ) {
            endCallback();
            return;
        }

        v.readWigData( chrName, min, max, dojo.hitch( this, function( features ) {
            array.forEach( features || [], featureCallback );
            endCallback();
        }), errorCallback );
    },

    getUnzoomedView: function() {
        if (!this.unzoomedView) {
            var cirLen = 4000;
            var nzl = this.zoomLevels[0];
            if (nzl) {
                cirLen = this.zoomLevels[0].dataOffset - this.unzoomedIndexOffset;
            }
            this.unzoomedView = new Window( this, this.unzoomedIndexOffset, cirLen, false );
        }
        return this.unzoomedView;
    },

    getView: function( scale ) {
        if( ! this.zoomLevels || ! this.zoomLevels.length )
            return null;

        if( !this._viewCache || this._viewCache.scale != scale ) {
            this._viewCache = {
                scale: scale,
                view: this._getView( scale )
            };
        }
        return this._viewCache.view;
    },

    _getView: function( scale ) {
        var basesPerPx = 1/scale;
        //console.log('getting view for '+basesPerSpan+' bases per span');
        var maxLevel = this.zoomLevels.length;
        if( ! this.fileSize ) // if we don't know the file size, we can't fetch the highest zoom level :-(
            maxLevel--;
        for( var i = maxLevel; i > 0; i-- ) {
            var zh = this.zoomLevels[i];
            if( zh && zh.reductionLevel <= 2*basesPerPx ) {
                var indexLength = i < this.zoomLevels.length - 1
                    ? this.zoomLevels[i + 1].dataOffset - zh.indexOffset
                    : this.fileSize - 4 - zh.indexOffset;
                //console.log( 'using zoom level '+i);
                return new Window( this, zh.indexOffset, indexLength, true );
            }
        }
        //console.log( 'using unzoomed level');
        return this.getUnzoomedView();
    }
});

});