/**
 * Created by forbiz on 2019-02-11.
 */

const module = () => {
    const $document = $(document);
    const ModuleFn = () => {
        let count = 1;

        const add = () => {
            return count++;
        };

        return {
            add : add
        };
    };


    //window.ModuleFn = ModuleFn;
    let btn_module = new ModuleFn();
    let btn_module_test = new ModuleFn();


    // $document jstree
    //     .on("click", ".modlue__btn", () => {
    //         console.log(btn_module.add());
    //         return false;
    //     })
    //     .on("click", ".modlue__btn-test", function() {
    //             var $this = $(this);
    //             var $target = $this.attr('data-target');
    //             $this.addCalss("active");
    //             //console.log(btn_module_test.add());
    //             //console.log($(this).attr("data-target"));
    //         return false;
    //     });

    function add(number) {
        var number_change = !isNaN(number) ? parseInt(number) : number;
        if (number_change > 1) {
            return number_change + add(number_change - 1)
        }
        return number;

        // var a = {};
        // var b = a;
        // console.log(a == b);
    }

    console.log(add("12"));
    //$('#container').jstree();

}

export default module;