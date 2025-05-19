<h2>Ma progression par catégorie</h2>
@foreach ($resultats as $item)
    <div>
        <strong>{{ $item['categorie'] }}</strong>
        <div class="w-full bg-gray-200 h-4 rounded">
            <div class="bg-blue-500 h-4 rounded" style="width: {{ $item['progression'] }}%"></div>
        </div>
        <span>{{ $item['progression'] }}%</span>
    </div>
@endforeach
