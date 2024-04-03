/**
 * Created by forbiz on 2019-06-26.
 */
const shop_goodsList = () => {
    const $document = $(document);

    const chageGoodsGrid = () => {
        const $grid =  $('.br__goods-list__wrap');
        const $radio = $('.filters__grid input[type=radio]');
        $radio.on('change', function() {
            const $this = $(this);
            if($this.prop('checked')) {
                $radio.attr('checked',false);
                $this.attr('checked',true);
                $grid.removeClass('br__goods-list__wrap--normal br__goods-list__wrap--large');
                $grid.addClass(`br__goods-list__wrap--${$this.val()}`);
            }

        }).trigger('change');
    }

    const goodsFilter = () => {
        const $area = $('.br__filter-layer');

        const accordion = () => {
            const $wrap = $('.filter-layer__content__acco');
            const $btn =  $('.filter-layer .accordion__opner');
            $btn.on('click', function() {
                $(this).closest('.filter-layer__content__acco').toggleClass('filter-layer__content__acco--show')
                    .siblings().removeClass('filter-layer__content__acco--show');
            });
        }

        const sizeTextEdit = () => {
            const $wrap = $('.filter-layer__content__acco--size');
            const $textarea = $wrap.find('.accordion__opner__value');
            const $checkbox = $wrap.find('input[type=checkbox]');
            $wrap.on('change', 'input[type=checkbox]', function() {
               const sumText = $(this).closest('.filter-layer__content__acco').find('input[type=checkbox]').map(function(idx, _this) {
                   if(_this.checked) return $(_this).next().text();
               }).toArray().join(', ');
                $(this).closest('.filter-layer__content__acco').find('.accordion__opner__value').text(sumText);

            });

            $checkbox.first().trigger('change');
        }

        const colorTextEdit = () => {
            const $wrap = $('.filter-layer__content__acco--color');
            const $textarea = $wrap.find('.accordion__opner__value');
            const $checkbox = $wrap.find('input[type=checkbox]');
            $wrap.on('change', 'input[type=checkbox]', function() {
                const sumText =  $(this).closest('.filter-layer__content__acco').find('input[type=checkbox]').map(function(idx, _this) {
                    if(_this.checked) return $(_this).siblings().text();
                }).toArray().join(', ');
                $(this).closest('.filter-layer__content__acco').find('.accordion__opner__value').text(sumText);
            });
            $checkbox.first().trigger('change');
        }

        const priceTextEdit = () => {
            const $wrap = $('.accordion__content__input');
            const $radio = $('.filter-layer__content__acco--price input[type=radio]');
            const $textarea = $('.filter-layer__content__acco--price .accordion__opner__value');
            $radio.on('change', function() {
                const $textRadio = $('.accordion__content__input input[type=radio]');
                let _textVal = '';
                $wrap.find('input[type=text]').attr('disabled', !$textRadio.prop('checked'));
                if($textRadio.prop('checked')) {
                    const $inputs = $wrap.find('input[type=text]');
                    const _unit = $wrap.find('.unit').eq(0).text();
                    const inputCheck = $inputs.eq(0).val() && $inputs.eq(1).val() ? true : false;
                    if(inputCheck) _textVal = `${$inputs.eq(0).val()}${_unit} - ${$inputs.eq(1).val()}${_unit}`;
                }else {
                    _textVal = $(this).closest('.accordion__content__label').find('.title').text();
                }
                $textarea.text(_textVal);

            }).trigger('change');
        }

        const resetFilter = () => {
            const $resetBtn = $('.filter-layer__btn__reset');
            const $checkbox = $area.find('input[type=checkbox]');
            const $radio = $area.find('input[type=radio]');
            const $textarea = $('.accordion__opner__value');
            $resetBtn.on('click', function() {
               $checkbox.attr('checked', false).prop('checked', false).first().trigger('change');
               $radio.attr('checked', false).prop('checked', false).first().trigger('change');
               $textarea.html(" ");
            });
        }

        const layerClose = () => {
            $area.on('click', '.filter-layer__close',function() {
               $area.removeClass('br__filter-layer--show');
            });
        }

        const layerOpen = () => {
            const $openBtn = $('.filters__btn');
            $openBtn.on('click', function() {
                $area.addClass('br__filter-layer--show');
            });
        }

        const goodsFilter_init = () => {
            accordion();
            sizeTextEdit();
            priceTextEdit();
            resetFilter();
            layerClose();
            layerOpen();
            colorTextEdit();

        }
        goodsFilter_init();
    }

    const goodsCategory = () => {
        const $btnOpen = $('.br__title-box__title button, .br__title-box__title a');
        const $layer = $('.br__category-layer');

        $btnOpen.on('click', function() {
            bodyScroll.fix();
            $layer.addClass('br__category-layer--show');
        });
        $layer.on('click', '.cate-layer__close', function() {
            bodyScroll.release();
            $layer.removeClass('br__category-layer--show');
        })
            .on('click', '.cate-layer__toggle', function() {
                $(this).closest('.cate-layer__box').toggleClass('cate-layer__box--active');
            });
    }
    const shop_goodsList_init = () => {
        chageGoodsGrid();
        goodsFilter();
        goodsCategory();
    }
    shop_goodsList_init();
}


export default shop_goodsList;