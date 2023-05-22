<table class="table {{ $class ?? '' }}">
    @isset($columns)
        <thead>
            <tr>
                {!! $columns !!}
            </tr>
        </thead>
    @endisset
    <tbody>
        {!! $rows !!}
    </tbody>
</table>  