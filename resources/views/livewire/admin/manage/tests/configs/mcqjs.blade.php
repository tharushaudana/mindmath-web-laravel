<script>

var struct = [];

function addStruct() {
    struct.unshift({
        'nquestions': 0,
        'operation_order': '',
        'digits_order': '',
        'shuffle_operation_order': 0,
        'shuffle_digits_order': 0,
    });

    renderStructContent();
}

function showStructEditModal(structStr) {
    $('#structModal').modal();
}

function renderStructContent() {
    var content = '';
    
    for (let i = 0; i < struct.length; i++) {
        const item = struct[i];

        content += `
            <div class="card">
                <div class="card-body p-2">
                    <div class="w-100 d-flex justify-content-between">
                        <div>
                            <span class="text-muted" style="font-size: 12px;">Question Count</span>
                            <input oninput="onChangeStruct(${i}, 'nquestions', this.value)" type="number" class="form-control" min="1" style="width: 80px;" value="${item['nquestions']}">
                            <br>
                            <button onclick="onClickRemoveStructItem(${i})" class="btn btn-outline-danger btn-sm">Remove</button>
                        </div>
                        <div>
                            <div>
                                <div class="d-flex">
                                    <span class="text-muted" style="font-size: 10px; margin-right: 10px;">Operation Order</span>
                                    <i onclick="onClickOperationAddBtn(${i}, '+')" class="fa-sharp fa-solid fa-plus" style="font-size: 8px; color: #000; border: 1px solid #000; padding: 2px; margin-right: 1px; cursor: pointer;"></i>
                                    <i onclick="onClickOperationAddBtn(${i}, '-')" class="fa-sharp fa-solid fa-minus" style="font-size: 8px; color: #000; border: 1px solid #000; padding: 2px; margin-right: 1px; cursor: pointer;"></i>
                                    <i onclick="onClickOperationAddBtn(${i}, '*')" class="fa-sharp fa-solid fa-xmark" style="font-size: 8px; color: #000; border: 1px solid #000; padding: 2px; margin-right: 1px; cursor: pointer;"></i>
                                    <i onclick="onClickOperationAddBtn(${i}, '/')" class="fa-sharp fa-solid fa-divide" style="font-size: 8px; color: #000; border: 1px solid #000; padding: 2px; margin-right: 1px; cursor: pointer;"></i>
                                    <i onclick="onClickOperationsClearBtn(${i})" class="fa-sharp fa-solid fa-eraser" style="font-size: 12px; color: #f00; padding: 2px; margin-right: 1px; cursor: pointer;"></i>
                                </div>
                                <div class="form-control mt-1 d-flex" style="height: 30px;" id="operation-order-viewer-${i}">
                                    ${htmlOperationOrderViewer(i)}
                                </div>
                                <div class="mt-1" id="checkbox-shuffle-operation-order-${i}" style="display: ${item['operation_order'].split(',').length > 1 ? 'flex' : 'none'};">
                                    <input onchange="onChangeStruct(${i}, 'shuffle_operation_order', this.checked ? 1 : 0)" type="checkbox" value="1" ${item['shuffle_operation_order'] === 1 ? 'checked' : ''}>
                                    <span style="font-size: 11px; font-weight: 500;">&nbsp;&nbsp;Shuffle</span>
                                </div>
                            </div>
                            <div>
                                <span class="text-muted" style="font-size: 10px;">Digits Order</span>
                                <br>
                                <input oninput="onInputDigitsOrder(${i}, this)" type="text" class="form-control" min="1" style="height: 20px; font-size: 14px;" value="${item['digits_order']}">
                                <div class="mt-1" id="checkbox-shuffle-digits-order-${i}" style="display: ${item['digits_order'].split(',').length > 1 ? 'flex' : 'none'};">
                                    <input onchange="onChangeStruct(${i}, 'shuffle_digits_order', this.checked ? 1 : 0)" type="checkbox" value="1" ${item['shuffle_digits_order'] === 1 ? 'checked' : ''}>
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
    struct.splice(index);
    renderStructContent();
}

function onClickOperationAddBtn(index, symbol) {
    var order = struct[index]['operation_order'];

    if (order.length == 0)
        order += `${symbol}`;
    else 
        order += `,${symbol}`;

        onChangeStruct(index, 'operation_order', order);

    if (order.split(',').length <= 1) {
        $(`#checkbox-shuffle-operation-order-${index}`).css('display', 'none');
    } else if (!order.split(',').every( (val, i, arr) => val === arr[0])) {
        $(`#checkbox-shuffle-operation-order-${index}`).css('display', 'flex');
    }

    $(`#operation-order-viewer-${index}`).html(htmlOperationOrderViewer(index));
}

function onClickOperationsClearBtn(index) {
    onChangeStruct(index, 'operation_order', '');
    $(`#operation-order-viewer-${index}`).html(htmlOperationOrderViewer(index));
    $(`#checkbox-shuffle-operation-order-${index}`).css('display', 'none');
}

function htmlOperationOrderViewer(index) {
    const order = struct[index]['operation_order'];
    
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
            if (struct[index]['operation_order'] === '' || validChars.length === struct[index]['operation_order'].split(',').length + 1) {
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

    if (!noChanges) onChangeStruct(index, 'digits_order', order);
}

function onChangeStruct(index, key, value) {    
    struct[index][key] = value;
    console.log(struct);
}
    
</script>