<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
    @php
        $favicon = $globalSetting->favicon ?? null;
        $logo = $globalSetting->logo ?? null;
    @endphp
  <link rel="icon"
    href="{{ $favicon ? asset('storage/'.$favicon) : asset('assets/img/favicon.jpg') }}">
  <title>Teqhitch ICT Academy LTD - Seminar & Project Topics Portal</title>
  
  <!-- Tailwind CSS v4 Browser Script -->
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4" crossorigin="anonymous"></script>

  <style>
    @keyframes spinSlow {
      from { transform: rotate(0deg); }
      to { transform: rotate(360deg); }
    }
    .spiral {
      animation: spinSlow 40s linear infinite;
      transform-origin: center;
    }
  </style>
</head>
<body class="bg-slate-50 text-slate-900 font-sans min-h-screen flex flex-col antialiased">

  <!-- Responsive Header -->
  <header class="bg-slate-900 text-white shadow-md sticky top-0 z-30 border-b border-cyan-500/30">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 min-h-16 sm:h-20 py-2.5 sm:py-0 flex items-center gap-2">
      <div class="w-10 h-10 sm:w-12 sm:h-12 shrink-0 flex items-center justify-center bg-white rounded-full p-1 shadow-inner">
        <img src="{{ $logo ? asset('uploads/'.$logo) : asset('assets/img/favicon.jpg') }}" alt="Teqhitch ICT Academy LTD Logo" class="w-full h-full object-contain" />
      </div>
      <div class="min-w-0">
        <h1 class="text-base sm:text-xl font-bold tracking-tight bg-gradient-to-r from-cyan-400 via-teal-300 to-lime-400 bg-clip-text text-transparent truncate">
          <a href="{{ route('home') }}">Teqhitch ICT Academy LTD</a> 
        </h1>
        <p class="text-[10px] sm:text-xs text-slate-300 font-medium truncate">
          Academic Seminar & Project Repository
        </p>
      </div>
    </div>
  </header>

  <!-- Hero Section -->
  <section class="bg-gradient-to-br from-slate-900 via-teal-950 to-slate-900 text-white py-14 px-4 sm:px-6 lg:px-8 border-b border-teal-500/20 relative overflow-hidden">
    <svg class="spiral absolute -right-40 -top-40 md:-right-24 md:-top-32 w-[560px] h-[560px] opacity-90 pointer-events-none z-0" viewBox="0 0 400 400" fill="none">
      <circle cx="200" cy="200" r="190" stroke="url(#g1)" stroke-width="18" stroke-dasharray="12 26" opacity="0.5"/>
      <circle cx="200" cy="200" r="150" stroke="url(#g2)" stroke-width="14" stroke-dasharray="4 18" opacity="0.6"/>
      <circle cx="200" cy="200" r="108" stroke="url(#g3)" stroke-width="10" opacity="0.55"/>
      <defs>
        <linearGradient id="g1" x1="0" y1="0" x2="400" y2="400">
          <stop offset="0%" stop-color="#1C54E8"/>
          <stop offset="100%" stop-color="#22B8CF"/>
        </linearGradient>
        <linearGradient id="g2" x1="0" y1="400" x2="400" y2="0">
          <stop offset="0%" stop-color="#22B8CF"/>
          <stop offset="100%" stop-color="#14B8A0"/>
        </linearGradient>
        <linearGradient id="g3" x1="0" y1="0" x2="400" y2="400">
          <stop offset="0%" stop-color="#14B8A0"/>
          <stop offset="100%" stop-color="#A6E635"/>
        </linearGradient>
      </defs>
    </svg>

    <div class="max-w-4xl mx-auto text-center space-y-4 relative z-10">
      <h2 class="text-3xl sm:text-4xl font-extrabold tracking-tight">
        Projects & Seminar Topics
      </h2>
      <p class="text-slate-300 text-base sm:text-lg max-w-2xl mx-auto">
        Explore verified research topics, problem statements, and standard 5-chapter outlines ready for supervisor submission.
      </p>

      <!-- Search Input -->
      <div class="mt-8 max-w-2xl mx-auto relative">
        <div class="relative flex items-center">
          <input 
            type="text" 
            id="searchInput"
            placeholder="Search topics, keywords, software, or methods..." 
            class="w-full pl-11 pr-4 py-3.5 rounded-xl bg-white text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-cyan-400/50 shadow-lg border border-slate-200"
          />
          <svg class="w-5 h-5 text-slate-400 absolute left-4 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
          </svg>
        </div>
      </div>
    </div>
  </section>

  <!-- Main Content -->
  <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 flex-1 w-full">
    
    <!-- Filter Controls Bar -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4 mb-8 flex flex-col md:flex-row items-center justify-between gap-4">
      <div class="flex flex-wrap items-center gap-3 w-full md:w-auto">
        <div class="w-full sm:w-auto flex-1 sm:flex-initial">
          <label class="block text-xs font-medium text-slate-500 mb-1">Department</label>
          <select id="departmentFilter" class="w-full bg-slate-50 border border-slate-300 text-slate-700 text-sm rounded-lg p-2.5 focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500">
            <option value="All">All Departments</option>
            @foreach($departments as $dept)
              <option value="{{ $dept }}">{{ $dept }}</option>
            @endforeach
          </select>
        </div>

        <div class="w-full sm:w-auto flex-1 sm:flex-initial">
          <label class="block text-xs font-medium text-slate-500 mb-1">Topic Type</label>
          <select id="typeFilter" class="w-full bg-slate-50 border border-slate-300 text-slate-700 text-sm rounded-lg p-2.5 focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500">
            <option value="All">All Types</option>
            @foreach($paperTypes as $type)
              <option value="{{ $type }}">{{ $type }}</option>
            @endforeach
          </select>
        </div>
      </div>

      <div class="text-sm text-slate-500 self-end md:self-center font-medium">
        Showing <span id="topicCount" class="font-bold text-slate-800">{{ $topics->count() }}</span> topics
      </div>
    </div>

    <!-- Container for Server-Rendered Blade Cards -->
    <div id="topicsContainer" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($topics as $topic)
        <div class="bg-white rounded-xl border border-slate-200 hover:border-cyan-500/50 hover:shadow-lg hover:shadow-cyan-500/5 transition-all duration-200 flex flex-col justify-between p-5 group">
            <div>
            <!-- Tags Header -->
            <div class="flex flex-wrap items-center gap-2 mb-3">
                <span class="px-2.5 py-1 text-xs font-semibold bg-cyan-50 text-cyan-700 rounded-md border border-cyan-200/60">
                {{ $topic->department ?? 'General' }}
                </span>
                <span class="px-2.5 py-1 text-xs font-medium bg-slate-100 text-slate-600 rounded-md">
                {{ $topic->paper_type ?? 'Project' }}
                </span>
                @if($topic->academic_level)
                <span class="px-2.5 py-1 text-xs font-medium bg-teal-50 text-teal-700 rounded-md">
                    {{ $topic->academic_level }}
                </span>
                @endif
            </div>

            <!-- Title -->
            <h3 class="text-base font-bold text-slate-900 group-hover:text-teal-600 transition-colors line-clamp-2 leading-snug mb-2">
                {{ $topic->title }}
            </h3>

            <!-- Description -->
            <p class="text-xs text-slate-600 line-clamp-3 leading-relaxed mb-4">
                {{ $topic->description ?? 'No detailed description available.' }}
            </p>
            </div>

            <!-- Card Action Footer -->
            <div class="pt-3 border-t border-slate-100 flex items-center justify-between mt-auto">
            <span class="text-xs text-slate-400">Standard 5-Chapter Outline</span>
            <button 
                type="button"
                onclick="openModal(this)"
                data-title="{{ $topic->title }}"
                data-description="{{ $topic->description ?? 'No detailed description available.' }}"
                data-department="{{ $topic->department ?? 'General' }}"
                data-paper_type="{{ $topic->paper_type ?? 'Project' }}"
                class="inline-flex items-center gap-1.5 text-xs font-semibold text-teal-600 hover:text-cyan-700 transition cursor-pointer"
            >
                View Full Details
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                </svg>
            </button>
            </div>
        </div>
        @empty
        <div class="col-span-full text-center py-16 bg-white rounded-xl border border-slate-200">
            <svg class="mx-auto h-12 w-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 9.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <h3 class="mt-2 text-base font-semibold text-slate-900">No topics found</h3>
            <p class="mt-1 text-sm text-slate-500">Try adjusting your search query or department filters.</p>
        </div>
        @endforelse
    </div>
  </main>

  <!-- Modal Component -->
  <div id="topicModal" class="fixed inset-0 bg-slate-950/70 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-3xl w-full max-h-[90vh] flex flex-col shadow-2xl overflow-hidden border border-slate-100">
      <div class="p-6 bg-slate-900 text-white flex justify-between items-start border-b border-slate-800">
        <div>
          <div class="flex flex-wrap gap-2 mb-2" id="modalBadges"></div>
          <h3 class="text-xl font-bold text-white leading-snug" id="modalTitle">Topic Title</h3>
        </div>
        <button onclick="closeModal()" class="text-slate-400 hover:text-white p-1 rounded-lg hover:bg-slate-800 transition">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
          </svg>
        </button>
      </div>

      <div class="p-6 overflow-y-auto space-y-6 text-slate-700">
        <div>
          <h4 class="text-xs font-bold uppercase tracking-wider text-teal-600 mb-2">Background & Description</h4>
          <p class="text-sm leading-relaxed bg-slate-50 p-4 rounded-lg border border-slate-200" id="modalOverview"></p>
        </div>

        <div>
          <h4 class="text-xs font-bold uppercase tracking-wider text-teal-600 mb-2">Standard Proposal Structure</h4>
          <div class="space-y-2 text-xs">
            <div class="p-2.5 bg-slate-100 rounded border border-slate-200"><strong>Chapter 1:</strong> Introduction, Background, Statement of Problem, Scope & Limitations</div>
            <div class="p-2.5 bg-slate-100 rounded border border-slate-200"><strong>Chapter 2:</strong> Theoretical Framework & Literature Review</div>
            <div class="p-2.5 bg-slate-100 rounded border border-slate-200"><strong>Chapter 3:</strong> System Design, Architecture & Research Methodology</div>
            <div class="p-2.5 bg-slate-100 rounded border border-slate-200"><strong>Chapter 4:</strong> Implementation, Testing & Result Analysis</div>
            <div class="p-2.5 bg-slate-100 rounded border border-slate-200"><strong>Chapter 5:</strong> Summary, Recommendation & Conclusion</div>
          </div>
        </div>
      </div>

      <div class="p-4 bg-slate-50 border-t border-slate-200 flex flex-col sm:flex-row items-center justify-between gap-3">
        <span class="text-xs text-slate-500">Ready to present to your lecturer?</span>
        <div class="flex items-center gap-3 w-full sm:w-auto">
          <button onclick="closeModal()" class="w-full sm:w-auto px-4 py-2 border border-slate-300 rounded-lg text-slate-700 text-sm hover:bg-slate-100 transition">Close</button>
          <button onclick="copyTopicTitle()" class="w-full sm:w-auto px-4 py-2 bg-gradient-to-r from-teal-600 to-cyan-600 text-white rounded-lg text-sm font-medium transition shadow-sm flex items-center justify-center gap-2">
            <span id="copyBtnText">Copy Topic</span>
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <footer class="bg-slate-900 text-slate-400 border-t border-slate-800 py-8 mt-12 text-center text-xs">
    <div class="max-w-7xl mx-auto px-4 space-y-2">
      <div class="flex items-center justify-center gap-2 mb-2">
        <img src="{{ $logo ? asset('uploads/'.$logo) : asset('assets/img/favicon.jpg') }}" alt="Teqhitch Logo" class="w-6 h-6 object-contain" />
        <span class="text-sm font-bold text-white">Teqhitch ICT Academy LTD</span>
      </div>
      <p>© {{ date('Y') }} Teqhitch ICT Academy LTD. All Rights Reserved.</p>
    </div>
  </footer>

  <!-- Clean AJAX Logic (Fetches Blade HTML, no JS string building) -->
  <script>
    const searchInput = document.getElementById('searchInput');
    const departmentFilter = document.getElementById('departmentFilter');
    const typeFilter = document.getElementById('typeFilter');
    const topicsContainer = document.getElementById('topicsContainer');
    const topicCount = document.getElementById('topicCount');

    let currentTitle = '';

    async function filterTopics() {
      const params = new URLSearchParams({
        search: searchInput.value,
        department: departmentFilter.value,
        paper_type: typeFilter.value
      });

      try {
        const response = await fetch(`{{ route('topics.filter') }}?${params.toString()}`);
        const data = await response.json();
        
        // Inject server-rendered Blade HTML partial
        topicsContainer.innerHTML = data.html;
        topicCount.textContent = data.count;
      } catch (error) {
        console.error('Filter request failed:', error);
      }
    }

    // Modal populated from dataset attributes
    function openModal(button) {
      currentTitle = button.dataset.title;
      
      document.getElementById('modalTitle').textContent = currentTitle;
      document.getElementById('modalOverview').textContent = button.dataset.description;
      document.getElementById('modalBadges').innerHTML = `
        <span class="px-2.5 py-1 text-xs font-semibold bg-cyan-500/20 text-cyan-300 rounded-md border border-cyan-500/30">${button.dataset.department}</span>
        <span class="px-2.5 py-1 text-xs font-medium bg-slate-800 text-slate-300 rounded-md">${button.dataset.paper_type}</span>
      `;

      document.getElementById('topicModal').classList.remove('hidden');
      document.body.style.overflow = 'hidden';
    }

    function closeModal() {
      document.getElementById('topicModal').classList.add('hidden');
      document.body.style.overflow = 'auto';
    }

    function copyTopicTitle() {
      if (!currentTitle) return;
      navigator.clipboard.writeText(currentTitle).then(() => {
        const copyBtnText = document.getElementById('copyBtnText');
        copyBtnText.textContent = "Copied to Clipboard!";
        setTimeout(() => copyBtnText.textContent = "Copy Topic", 2000);
      });
    }

    let debounceTimer;
    searchInput.addEventListener('input', () => {
      clearTimeout(debounceTimer);
      debounceTimer = setTimeout(filterTopics, 300);
    });

    departmentFilter.addEventListener('change', filterTopics);
    typeFilter.addEventListener('change', filterTopics);

    window.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') closeModal();
    });
  </script>
</body>
</html>