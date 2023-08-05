<script>

var struct = [];
var itemErrors = [];

window.livewire.on('structerrors', (json) => {
    removeAllItemErrors();
    itemErrors = JSON.parse(json);
    showAllItemErrors();
});

function showStructEditModal(structStr) {
    initStruct(structStr);
    $('#structModal').modal();
}

function initStruct(structStr) {
    struct = JSON.parse(structStr);
    itemErrors = [];
    renderStructContent();
    showAllItemErrors();
}

function addStruct() {
    struct.unshift({
        'nq': 0,  // nquestions
        'io': 1,  // intonly
        'oo': '', // operation_order
        'do': '', // digits_order
        'soo': 0, // shuffle_operation_order
        'sdo': 0, // shuffle_digits_order
    });

    sendStruct();

    renderStructContent();
}

function renderStructContent() {
    var content = '';
    
    for (let i = 0; i < struct.length; i++) {
        const item = struct[i];

        content += `
            <div class="card ${i == 0 ? 'bg-light' : ''}" style="position: relative;">
                <i onclick="onClickRemoveStructItem(${i})" class="fa-solid fa-square-minus text-danger" style="position: absolute; cursor: pointer;"></i>
                <div class="card-body p-2 mt-3">
                    <div class="w-100 d-flex justify-content-between">
                        <div>
                            <span class="text-muted" style="font-size: 12px;">Question Count</span>
                            <div class="input-group" id="si-${i}-nq">
                                <input oninput="onChangeStruct(${i}, 'nq', this.value)" type="number" class="form-control input" min="1" style="width: 80px;" value="${item['nq']}">
                                <div class="invalid-feedback">...</div>
                            </div>
                            <div class="mt-1 d-flex" id="checkbox-io-${i}">
                                <input onchange="onChangeStruct(${i}, 'io', this.checked ? 1 : 0)" type="checkbox" value="1" ${item['io'] === 1 ? 'checked' : ''}>
                                <span style="font-size: 11px; font-weight: 500;">&nbsp;&nbsp;Interger Answers Only</span>
                            </div>
                        </div>
                        <div class="ml-3">
                            <div>
                                <div class="d-flex">
                                    <span class="text-muted" style="font-size: 10px; margin-right: 10px;">Operation Order</span>
                                    <i onclick="onClickOperationAddBtn(${i}, '+')" class="fa-sharp fa-solid fa-plus" style="font-size: 8px; color: #000; border: 1px solid #000; padding: 2px; margin-right: 1px; cursor: pointer;"></i>
                                    <i onclick="onClickOperationAddBtn(${i}, '-')" class="fa-sharp fa-solid fa-minus" style="font-size: 8px; color: #000; border: 1px solid #000; padding: 2px; margin-right: 1px; cursor: pointer;"></i>
                                    <i onclick="onClickOperationAddBtn(${i}, '*')" class="fa-sharp fa-solid fa-xmark" style="font-size: 8px; color: #000; border: 1px solid #000; padding: 2px; margin-right: 1px; cursor: pointer;"></i>
                                    <i onclick="onClickOperationAddBtn(${i}, '/')" class="fa-sharp fa-solid fa-divide" style="font-size: 8px; color: #000; border: 1px solid #000; padding: 2px; margin-right: 1px; cursor: pointer;"></i>
                                    <i onclick="onClickOperationsClearBtn(${i})" class="fa-sharp fa-solid fa-eraser" style="font-size: 12px; color: #f00; padding: 2px; margin-right: 1px; cursor: pointer;"></i>
                                </div>
                                <div class="input-group mt-1" id="si-${i}-oo">
                                    <div class="form-control d-flex input" style="height: 30px;" id="operation-order-viewer-${i}">
                                        ${htmlOperationOrderViewer(i)}
                                    </div>
                                    <div class="invalid-feedback">...</div>
                                </div>
                                <div class="mt-1" id="checkbox-shuffle-operation-order-${i}" style="display: ${item['oo'].split(',').length > 1 ? 'flex' : 'none'};">
                                    <input onchange="onChangeStruct(${i}, 'soo', this.checked ? 1 : 0)" type="checkbox" value="1" ${item['soo'] === 1 ? 'checked' : ''}>
                                    <span style="font-size: 11px; font-weight: 500;">&nbsp;&nbsp;Shuffle</span>
                                </div>
                            </div>
                            <div>
                                <span class="text-muted" style="font-size: 10px;">Digits Order</span>
                                <br>
                                <div class="input-group" id="si-${i}-do">
                                    <input oninput="onInputDigitsOrder(${i}, this)" type="text" class="form-control input" min="1" style="height: 20px; font-size: 14px;" value="${item['do']}">
                                    <div class="invalid-feedback">...</div>
                                </div>
                                <div class="mt-1" id="checkbox-shuffle-digits-order-${i}" style="display: ${item['do'].split(',').length > 1 ? 'flex' : 'none'};">
                                    <input onchange="onChangeStruct(${i}, 'sdo', this.checked ? 1 : 0)" type="checkbox" value="1" ${item['sdo'] === 1 ? 'checked' : ''}>
                                    <span style="font-size: 11px; font-weight: 500;">&nbsp;&nbsp;Shuffle</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
    }

    $('#struct-content').html(content);
}

function onClickRemoveStructItem(index) {
    struct.splice(index, 1);
    sendStruct();
    renderStructContent();
}

function onClickOperationAddBtn(index, symbol) {
    var order = struct[index]['oo'];

    if (order.length == 0)
        order += `${symbol}`;
    else 
        order += `,${symbol}`;

        onChangeStruct(index, 'oo', order);

    if (order.split(',').length <= 1) {
        $(`#checkbox-shuffle-operation-order-${index}`).css('display', 'none');
    } else if (!order.split(',').every( (val, i, arr) => val === arr[0])) {
        $(`#checkbox-shuffle-operation-order-${index}`).css('display', 'flex');
    }

    $(`#operation-order-viewer-${index}`).html(htmlOperationOrderViewer(index));
}

function onClickOperationsClearBtn(index) {
    onChangeStruct(index, 'oo', '');
    $(`#operation-order-viewer-${index}`).html(htmlOperationOrderViewer(index));
    $(`#checkbox-shuffle-operation-order-${index}`).css('display', 'none');
}

function htmlOperationOrderViewer(index) {
    const order = struct[index]['oo'];
    
    if (order.length === 0) return '<span class="text-muted" style="font-size: 12px;"><i>Empty...</i></span>'; 

    const ops = order.split(',');
    var html = '';

    ops.forEach(op => {
        if (op === '+')
            html += '<i class="fa-sharp fa-solid fa-plus bg-dark" style="font-size: 10px; color: #000; padding: 2px; margin-right: 1px;"></i>';
        else if (op === '-')
            html += '<i class="fa-sharp fa-solid fa-minus bg-dark" style="font-size: 10px; color: #000; padding: 2px; margin-right: 1px;"></i>';
        else if (op === '*')
            html += '<i class="fa-sharp fa-solid fa-xmark bg-dark" style="font-size: 10px; color: #000; padding: 2px; margin-right: 1px;"></i>';
        else if (op === '/')
            html += '<i class="fa-sharp fa-solid fa-divide bg-dark" style="font-size: 10px; color: #000; padding: 2px; margin-right: 1px;"></i>';
    });

    return html;
}

function onInputDigitsOrder(index, e) {
    const chars = e.value.split('');

    var validChars = [];

    var noChanges = false;

    chars.forEach(c => {
        const n = parseInt(c);

        if (!isNaN(c) && n > 0) { 
            if (struct[index]['oo'] === '' || validChars.length === struct[index]['oo'].split(',').length + 1) {
                noChanges = true;
                return;
            }
            validChars.push(c);
        }
    });

    if (validChars.length <= 1) {
        $(`#checkbox-shuffle-digits-order-${index}`).css('display', 'none');
    } else if (!validChars.every( (val, i, arr) => val === arr[0])) {
        $(`#checkbox-shuffle-digits-order-${index}`).css('display', 'flex');
    } else {
        $(`#checkbox-shuffle-digits-order-${index}`).css('display', 'none');
    }

    const order = validChars.join(',');

    $(e).val(order);

    if (!noChanges) onChangeStruct(index, 'do', order);
}

function onChangeStruct(index, key, value) {    
    struct[index][key] = value;
    sendStruct();
}

function sendStruct() {
    @this.setValue('config.struct', JSON.stringify(struct));
}

function showAllItemErrors() {
    for (const [k, v] of Object.entries(itemErrors)) {
        showErrorOnItem(k, v);
    }
}

function showErrorOnItem(item, error) {
    $(`#${item} .invalid-feedback`).html(error);
    $(`#${item} .input`).addClass('is-invalid');
}

function removeAllItemErrors() {
    for (const [k, v] of Object.entries(itemErrors)) {
        $(`#${k} .input`).removeClass('is-invalid');
    }
}
    
</script>