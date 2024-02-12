@if ($errors->any())
    <div id="toasterContainer" @if (isset($style)) style="{{ $style }}" @else style="z-index: 99999; position: fixed; top: 110px; right: 50px; width: 300px;" @endif>

        <div class="toaster" style="background-color: #f8d7da; color: #721c24; padding: 10px; border-radius: 8px; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); opacity: 0; transition: opacity 0.5s ease-in-out, margin 0.5s ease-in-out; margin-bottom: 10px;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button style="background: none; border: none; color: inherit; cursor: pointer; font-size: larger;" onclick="closeToaster(this.parentElement)">×</button>
            </div>
        </div>

    </div>
@endif

<div id="toasterContainer" @if ( isset($style) ) style="{{ $style }}" @else style="z-index: 99999; position: fixed; top: 110px; right: 50px; width: 300px;" @endif>

    @if (Session::has('success'))
        <div class="toaster" style="background-color: #d4edda; color: #155724; padding: 10px; border-radius: 8px; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); opacity: 0; transition: opacity 0.5s ease-in-out, margin 0.5s ease-in-out; margin-bottom: 10px;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <span>{{ Session::get('success') }}</span>
                <button style="background: none; border: none; color: inherit; cursor: pointer; font-size: larger;" onclick="closeToaster(this.parentElement)">×</button>
            </div>
        </div>
    @endif

    @if (Session::has('info'))
        <div class="toaster" style="background-color: #cce5ff; color: #004085; padding: 10px; border-radius: 8px; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); opacity: 0; transition: opacity 0.5s ease-in-out, margin 0.5s ease-in-out; margin-bottom: 10px;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <span>{{ Session::get('info') }}</span>
                <button style="background: none; border: none; color: inherit; cursor: pointer; font-size: larger;" onclick="closeToaster(this.parentElement)">×</button>
            </div>
        </div>
    @endif

    @if (Session::has('danger') || Session::has('error'))
        <div style="background-color: #f8d7da; color: #721c24; padding: 10px; border-radius: 8px; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); opacity: 0; transition: opacity 0.5s ease-in-out, margin 0.5s ease-in-out; margin-bottom: 10px; display: flex; justify-content: space-between; align-items: center;" class="toaster">
            <div>
                {{ Session::has('danger') ? Session::get('danger') : Session::get('error') }}
            </div>
            <button style="background: none; border: none; color: inherit; cursor: pointer; font-size: larger;" onclick="closeToaster(this.parentElement)">×</button>
        </div>
    @endif

    @if (Session::has('warning'))
        <div class="toaster" style="background-color: #fff3cd; color: #856404; padding: 10px; border-radius: 8px; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); opacity: 0; transition: opacity 0.5s ease-in-out, margin 0.5s ease-in-out; margin-bottom: 10px;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <span>{{ Session::get('warning') }}</span>
                <button style="background: none; border: none; color: inherit; cursor: pointer; font-size: larger;" onclick="closeToaster(this.parentElement)">×</button>
            </div>
        </div>
    @endif
</div>

<script>
    function showToast() {
        let toasters = document.querySelectorAll('.toaster');

        // Display each toaster with a delay
        toasters.forEach(function(toaster, index) {
            setTimeout(function() {
                toaster.style.opacity = '1';

                // Hide the toaster after 5 seconds (adjust as needed)
                setTimeout(function() {
                    closeToaster(toaster, index);
                }, 5000);
            }, index * 100); // Add a delay between each toaster
        });
    }

    function closeToaster(toaster) {
        let closedToaster = toaster.parentElement;
        let nextToaster = closedToaster.nextElementSibling;

        // Animate the closing of the toaster
        closedToaster.style.opacity = '0';

        // Add a transition delay before removing the toaster
        setTimeout(function() {
            closedToaster.remove();

            // Shift down the following toasters
            if (nextToaster) {
                nextToaster.style.marginTop = '0';
            }
        }, 500); // Transition duration
    }


    // Call the showToast function to display the toasters
    showToast();
</script>
