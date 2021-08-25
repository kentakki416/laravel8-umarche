<x-tests.app>
  <x-slot name="header">ヘッダー１</x-slot>
コンポーネント１

<x-tests.card title="タイトル" content="本文" :message="$message"></x-tests.card>
<x-test-class-base classBaseMessage="メッセージ"></x-test-class-base>
<div class="mb-4"></div>
<x-test-class-base classBaseMessage="メッセージ" ></x-test-class-base>

</x-tests.app>