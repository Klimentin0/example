<x-layout>
    <x-slot:heading>
        Job listings
    </x-slot:heading>
  <ul>
    @foreach ($jobs as $job)
        <li>
            <a href="/jobs/{{ $job['id'] }}" class="text-blue-700 hover:underline" >
            {{ $job['title'] }}: Pays {{ $job['salary'] }} per year.
            </a>
        </li>

    @endforeach
  </ul>

</x-layout>
