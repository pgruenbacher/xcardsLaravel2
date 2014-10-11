<link rel="stylesheet" type="text/css" href="{{ URL::asset('packages/solitude/profiler/styles.css') }}" />
<div id="profiler">
    @foreach ($checkpoints as $checkpoint)

    <div class="checkpoint">
        <span class="number">Checkpoint #{{ $checkpoint['number'] }}</span>

        <div class="details">
            From line {{ $checkpoint['line'] }} in {{ $checkpoint['file'] }}
        </div>

        <span class="execution-time">{{ $checkpoint['executionTime'] }} sec.</span>
    </div>

    @endforeach

    <div class="checkpoint">
        <strong>Total execution time:</strong> {{ $totalExecutionTime }} sec.
    </div>

</div>