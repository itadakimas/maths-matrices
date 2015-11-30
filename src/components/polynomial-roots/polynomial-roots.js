define(function(require){

    var Vue      = require("vue"),
        template = require("text!./polynomial-roots.html");

    require("typedjs");

    return Vue.extend({

        data: function() {

            return {
                a0: null,
                a1: null,
                a2: null,
                a3: null,
                currentState: "default",
                isA0Invalid: false,
                isA1Invalid: false,
                isA2Invalid: false,
                isA3Invalid: false,
                isMenuOpened: false
            };
        },
        template: template,
        ready: function() {
            
            var now = new Date();
            var hours = now.getHours();
            var message = [
                ((hours > 17 || hours < 5) ? "Bonsoir" : "Bonjour") + " très cher visiteur !",
                "Pour commencer, ^600 choisissez une étape en cliquant sur le bouton de gauche."
            ];
            
            this.typeWrite(this.$$.welcomeTitle, message, 3000);
        },
        methods: {
            isCoefficientValid: function(coefficient) {
                
                var value = new Number(coefficient);
                
                if (!isNaN(value))
                {
                    return true;
                }
                return false;
            },
            observeCoefficients: function() {
                
                console.log("observeCoefficients");
            },
            onBurgerMenuClick: function() {
                
                this.isMenuOpened = !this.isMenuOpened;
            },
            onStepButtonClick: function(step) {
                
                this.isMenuOpened = false;
                this.currentState = "step-" + step;
            },
            typeWrite: function(el, message, delay) {
                    
                var timeoutID = setTimeout(function(){
                    
                    $(el).slideDown(200, function(){
                        
                        $(this).typed({
                            strings: message,
                            typeSpeed: 30
                        });
                        
                    });
                    clearTimeout(timeoutID);
                    
                }.bind(this), delay); 
            }
        },
        watch: {
            a0: function(value) {
                
                if (this.isCoefficientValid(value))
                {
                    this.isA0Invalid = false;
                    this.observeCoefficients();
                }
                else
                {
                    this.isA0Invalid = true;
                }
            },
            a1: function(value) {
                
                if (this.isCoefficientValid(value))
                {
                    this.isA1Invalid = false;
                    this.observeCoefficients();
                }
                else
                {
                    this.isA1Invalid = true;
                }
            },
            a2: function(value) {
                
                if (this.isCoefficientValid(value))
                {
                    this.isA2Invalid = false;
                    this.observeCoefficients();
                }
                else
                {
                    this.isA2Invalid = true;
                }
            },
            a3: function(value) {
                
                if (this.isCoefficientValid(value))
                {
                    this.isA3Invalid = false;
                    this.observeCoefficients();
                }
                else
                {
                    this.isA3Invalid = true;
                }
            },
            currentState: function(val) {
                
                if (val === "step-1")
                {
                    this.typeWrite(this.$$.step1Title, [
                        "Étape 1 : ^500 racines entières d'un polynôme de degré 3.",
                        "Saisissez les coefficients du polynôme pour obtenir les racines entières."
                    ], 1000);
                }
            }
        }
    });
});
