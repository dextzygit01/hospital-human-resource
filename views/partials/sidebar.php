<aside class="bg-white shadow-lg w-64 min-h-screen hidden md:block">
  <div class="p-4 border-b">
    <h2 class="text-xl font-semibold">HR Department</h2>
  </div>

  <nav class="p-4 space-y-4 text-sm">
    <!-- Department Applicant Requests -->
    <div>
      <p class="text-gray-500 uppercase text-xs mb-2">Department Requests</p>
      <a href="/hr_system/request/add.php" class="flex items-center gap-2 px-3 py-2 rounded hover:bg-blue-100">
        <i data-lucide="file-plus"></i> Add Request
      </a>
      <a href="/hr_system/request/view.php" class="flex items-center gap-2 px-3 py-2 rounded hover:bg-blue-100">
        <i data-lucide="list"></i> View Requests
      </a>
    </div>

    <!-- Talent Acquisition & Workforce Entry -->
    <div>
      <p class="text-gray-500 uppercase text-xs mt-4 mb-2">Talent Acquisition</p>

      <a href="/hr_system/applicants/add.php" class="flex items-center gap-2 px-3 py-2 rounded hover:bg-blue-100">
        <i data-lucide="user-plus"></i> Applicant Management
      </a>

      <a href="/hr_system/recruitment/add.php" class="flex items-center gap-2 px-3 py-2 rounded hover:bg-blue-100">
        <i data-lucide="briefcase"></i> Recruitment Management
      </a>

      <!-- New Hire Onboarding -->
      <div class="px-3 py-2 rounded hover:bg-blue-50">
        <div class="flex items-center gap-2 text-gray-700 font-semibold">
          <i data-lucide="user-check"></i> New Hire Onboarding
        </div>
        <div class="ml-6 mt-2 space-y-1 text-sm text-gray-600">
          <a href="/hr_system/hires/list.php" class="block hover:underline">List</a>
          <a href="/hr_system/hires/add.php" class="block hover:underline">Add</a>
          <a href="/hr_system/hires/edit.php?id=1" class="block hover:underline">Edit</a>
          <a href="/hr_system/hires/delete.php?id=1" class="block hover:underline">Delete</a>
        </div>
      </div>
    </div>

    <!-- Performance Management -->
    <div>
      <p class="text-gray-500 uppercase text-xs mt-6 mb-2">Performance Management</p>

      <a href="/hr_system/performance/review.php" class="flex items-center gap-2 px-3 py-2 rounded hover:bg-blue-100">
        <i data-lucide="bar-chart-2"></i> Initial Reviews
      </a>

      <a href="/hr_system/recognition/give.php" class="flex items-center gap-2 px-3 py-2 rounded hover:bg-blue-100">
        <i data-lucide="star"></i> Social Recognition
      </a>

      <a href="/hr_system/ai/track.php?hire_id=1" class="flex items-center gap-2 px-3 py-2 rounded hover:bg-blue-100">
        <i data-lucide="cpu"></i> Azure AI Tracking
      </a>
    </div>

    <!-- System Navigation -->
    <div>
      <p class="text-gray-500 uppercase text-xs mt-6 mb-2">System</p>

      <a href="/hr_system/index.php" class="flex items-center gap-2 px-3 py-2 rounded hover:bg-blue-100">
        <i data-lucide="home"></i> Main Dashboard
      </a>
    </div>
  </nav>
</aside>
