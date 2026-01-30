<div id="timelineMinimal" class="col-lg-12 layout-spacing mt-4">
    <div class="statbox widget box box-shadow">
        <div class="widget-header">
            <div class="row">
                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                    <h4>Workflow</h4>
                </div>
            </div>
        </div>
        <div class="widget-content widget-content-area pb-1">
            <div class="mt-container mx-auto">
                <div class="timeline-line">
                    <?php
                    //   var_dump($workflows);die;
                    ?>
                    @foreach ($workflows as $row)
                    <div class="item-timeline">
                        <p class="t-time">{{ \Carbon\Carbon::parse($user_entry->created_at)->format('d-m-Y H:i:s') }}</p>
                        <div class="t-dot {{ $row->appl_status == 'RE' ? 't-dot-danger' : 't-dot-info' }}"></div>
                        <div class="t-text">
                            <p>{{ $row->appl_status == 'RE' ? 'Return By': 'Processed by:'}} {{ $row->processed_by }}</p>
                            <p class="t-meta-time">
                                @if (!$row->name)
                                Approved By: {{ $row->processed_by }}
                                @else()
                                Forwarded to: {{ $row->name }} → Remarks: {{ $row->remarks }}</p>
                            @endif
                        </div>
                    </div>
                    @endforeach
                    <div class="item-timeline">
                        <p class="t-time">{{ \Carbon\Carbon::parse($user_entry->created_at)->format('d-m-Y H:i:s') }}</p>
                        <div class="t-dot {{ $user_entry->id ? 't-dot-info' : 't-dot-warning' }}"></div>
                        <div class="t-text">
                            <p>Applicant Submitted the Application</p>
                            <p class="t-meta-time">Form: {{ $user_entry->form_name }}, License: {{ $user_entry->license_name }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>