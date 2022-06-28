<div class="w-100 h-100">
    <div class="h-100 w-100">
        <div class="p-3 ListStockCima w-100">
            <title>Stock</title>
            <h4 class="text-secondary"><strong>Stock</strong></h4>
            <div class="d-flex w-100">

            </div>
        </div>
        <div class="ResultadoStock"></div>
        <div class=" w-100 ListStockBaixo overflow-auto">
            <div class="w-100 ListaArmagens">
                @foreach ($Armagens as $armagen)
                <div class="ArmagensForme shadow rounded border">
                    <div class="h-1 w-100 NomeArmagens d-flex shadow rounded text-shadow">
                        <img src="/storage/armagem/armagem.jpg" alt="">
                        <div class="text-center">
                            <div class="w-100 ps-2 text-secondary nomeArmagen">{{$armagen->NomeArmagen}}</div>
                            <div class="stockDisponivel mt-4 d-flex" IdArmagen="{{$armagen->id}} ">
                                <i class="fa fa-bar-chart stock mt-3"></i>
                                <div class="mt-2">
                                    <div>{{Number_format(DB::table('stocks')->where('IdArmagen',$armagen->id)->sum('quantidade'),2,",",".")."Un(s)"}} </div>
                                    <span>Stock</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
<script src="csss/Stock/Armagem.js"></script>

