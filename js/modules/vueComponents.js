import * as modules from "./modules.js";

function init() {
    return new Promise(function(resolve,reject){
        Vue.component('remoteValueInputField', {
            "props": [
                'getDataValues',
                'getDataValueName',
                'actionValues',
                'type'
            ],
            "data": function () {
                return {
                    value: "",
                    modules: modules
                };
            },
            "methods": {
                "getRemoteValue": async function() {
                    let parameters = JSON.parse(this.getDataValues);
                    let data = await this.modules.network.getDataRequest(parameters);
                    this.value = $(data).find(this.getDataValueName)[0].textContent;
                },
                "setRemoteValue": function() {
                    let element = this.$el;
                    let parameters = $.extend(JSON.parse(this.actionValues), {newValue: this.value});
                    this.modules.network.actionRequest(parameters)
                    .catch(function() {
                        $(element).addClass("invalidValue");
                    });
                },
                "invalidValue": function() {
                    if(this.value === "") {
                        return true;
                    }
                    if(this.type == "email") {
                        var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                        return !re.test(String(this.value).toLowerCase());
                    }
                    
                    return false;
                }
            },
            "watch": {
                "value": function() {
                    if(this.invalidValue()) {
                        $(this.$el).addClass("invalidValue");
                    }else {
                        $(this.$el).removeClass("invalidValue");
                        clearTimeout(this.timer);
                        this.timer = setTimeout(function(setRemoteValue){setRemoteValue(); }, 1000, this.setRemoteValue);
                    }
                }
            },
            "mounted": function () {
                this.getRemoteValue();
            },
            "template": '<input v-model:value="value"></input>'
        });
        
        Vue.component('avatar', {
            "props": [
                'username'
            ],
            "data": function () {
                return {
                    modules: modules
                };
            },
            "methods": {
                "load": function() {
                    
                }
            },
            "mounted": function () {
                this.load();
            },
            "template": '<img v-on:click="modules.account.toggleDropdown()" class="avatarImg">'
        });
        Vue.component('pixelArtEditor', {
            "props": [
                "pixelArtId"
            ],
            "data": function() {
                return {
                    "colors": [],
                    "selectedColor": "black",
                    "modules": modules,
                    "pixels": [],
                    "width": 16,
                    "height": 16,
                    "mouseDown": false
                }
            },
            "methods": {
                "setupPixels": function() {
                    this.pixels = [];
                    for(let i = 0; i < this.width*this.height; i++) {
                        this.pixels.push("#ffffff");
                    }
                },
                "getColors": function() {
                    let component = this;
                    $.get("/getData.php?getData=avatar:colors")
                    .then(function(data) {
                        let children = $(data).find("results")[0].children;
                        
                        for(let colorName in children) {
                            if(children[colorName].innerHTML) {
                                component.colors.push(children[colorName].innerHTML);
                            }
                        }
                        
                        console.log(component.colors);
                    });
                },
                "setupCanvas": function() {
                    this.canvas = $("#pixelArtPreview")[0];
                    this.ctx = this.canvas.getContext('2d');
                    
                    console.log(this.canvas);
                    console.log(this.ctx);
                    
                    $(window).resize(this.canvasResized);
                    
                    this.canvas.addEventListener('mousedown', this.onMouseDown, false);
                    this.canvas.addEventListener('mouseup', this.onMouseUp, false);
                    this.canvas.addEventListener('mousemove',this.checkForClick, false);
                },
                "redrawCanvas": function() {
                    this.ctx.clearRect(0, 0, this.realWidth, this.realHeight);
                    
                    for(let x = 0; x < this.width; x++) {
                        for(let y = 0; y < this.height; y++) {
                            this.fillField(x,y,this.pixels[x*this.width+y],false);
                        }
                    }
                },
                "fillField": function(x,y,color,updatePixelsArray) {
                    if(updatePixelsArray) {
                        this.pixels[x*this.width+y] = color;
                    }
                    
                    let fieldWidth = this.canvas.width/this.width;
                    let fieldHeight = this.canvas.height/this.height;
                    
                    // fill field
                    this.ctx.fillStyle = color;
                    this.ctx.strokeStyle = "";
                    this.ctx.fillRect(x * fieldWidth, y * fieldHeight, fieldWidth, fieldHeight);
                    
                    // draw field lines
                    this.ctx.fillStyle = "";
                    this.ctx.strokeStyle = "black";
                    this.ctx.strokeRect(x * fieldWidth, y * fieldHeight, fieldWidth, fieldHeight);
                },
                "getRelativeCoords": function(event) {
                    let x = Math.floor(event.offsetX / this.realWidth * this.width);
                    let y = Math.floor(event.offsetY / this.realHeight * this.height);
                    
                    console.log({x, y});
                    
                    return {x, y};
                },
                "checkForClick": function(event) {
                    if(this.mouseDown) {
                        this.clicked(event);
                    }
                },
                "clicked": function(event) {
                    let coordinates = this.getRelativeCoords(event);
                    
                    this.fillField(coordinates.x, coordinates.y, this.selectedColor, true);
                },
                "canvasResized": function() {
                    this.realWidth = $(this.canvas).width();
                    this.realHeight = $(this.canvas).height();
                    
                    this.canvas.width = this.realWidth;
                    this.canvas.height = this.realHeight;
                    
                    this.redrawCanvas();
                },
                "onMouseUp": function () {
                  this.mouseDown = false;
                },
                "onMouseDown": function () {
                  this.mouseDown = true;
                },
                "fromString": function() {
                    
                },
                "fromOldString": function() {
                    
                },
                "toString": function() {
                    let output = "";
                    for(let x = 0; x < this.width; x++) {
                        for(let y = 0; y < this.height; y++) {
                            output += this.pixels[x*this.width+y];
                            output += "; ";
                        }
                        output += "|"
                    }
                    
                    return output;
                }
            },
            "computed": {
            },
            "watch": {
            },
            "lang": {
            },
            "mounted": function() {
                this.setupPixels();
                this.getColors();
                this.setupCanvas();
                this.canvasResized();
            },
            "template": '<div>'+
                            '<div style="position: absolute; left: 10vw; top: 50%; transform: translateY(-50%); display: flex; flex-direction: column; flex-wrap: nowrap; max-height: 70vh; overflow-y: scroll;">' +
                                '<div v-for="color in colors" :key="color" v-bind:style="{background: color}" style="width: 7vh; height: 7vh; flex-shrink: 0; flex-grow: 0;" v-on:click="selectedColor = color;"></div>' +
                            '</div>' +
                            '<div>' +
                                '<canvas id="pixelArtPreview" v-on:click="clicked" style="width: 50vw; height: 50vw; position: absolute; top: 50%; left: 50%; transform: translate(-50%,-50%);"></canvas>' +
                            '</div>' +
                            '<div style="position: absolute; bottom: 5vh; right: 5vw;">' +
                                '<button v-on:click="console.log(toString());" class="button whiteBorder transparentBackground whiteHoverBorder whiteHoverBackground whiteText blackHoverText">Save</button>' +
                            '</div>' +
                        '</div>'
        });
        
        resolve();
    });
}

export {init};