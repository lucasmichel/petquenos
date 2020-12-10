package com.example.petqueno;

import androidx.appcompat.app.AlertDialog;
import androidx.appcompat.app.AppCompatActivity;

import android.annotation.TargetApi;
import android.content.DialogInterface;
import android.os.Build;
import android.os.Bundle;
import android.view.ContextThemeWrapper;
import android.view.Window;
import android.view.WindowManager;
import android.webkit.PermissionRequest;
import android.webkit.WebChromeClient;
import android.webkit.WebView;
import android.webkit.WebViewClient;

public class MainActivity extends AppCompatActivity {



    private String GlobalUrl="https://petquenos.com.br/";

    final int MY_PERMISSIONS_REQUEST_LOCATION=1;

    WebView mWebView;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        //setContentView(R.layout.activity_main);

        requestWindowFeature(Window.FEATURE_NO_TITLE);
        getWindow().setFlags(WindowManager.LayoutParams.FLAG_FULLSCREEN,
                WindowManager.LayoutParams.FLAG_FULLSCREEN);//deixa em full screen

        setContentView(R.layout.activity_main);
        setTitle(" ");

        mWebView = findViewById(R.id.webbView);
        //mWebView.setBackgroundColor(Color.parseColor("#570258"));


        mWebView.getSettings().setJavaScriptCanOpenWindowsAutomatically(true);
        mWebView.getSettings().setBuiltInZoomControls(true);
        //mWebView.setWebViewClient(new GeoWebViewClient());
        // Below required for geolocation
        mWebView.getSettings().setJavaScriptEnabled(true);
        mWebView.getSettings().setAppCacheEnabled(true);
        mWebView.getSettings().setDatabaseEnabled(true);
        mWebView.getSettings().setJavaScriptCanOpenWindowsAutomatically(true);
        mWebView.getSettings().supportMultipleWindows();
        mWebView.getSettings().setGeolocationEnabled(true);


        mWebView.getSettings().setAllowFileAccessFromFileURLs(true);
        mWebView.getSettings().setAllowUniversalAccessFromFileURLs(true);
        mWebView.getSettings().setJavaScriptCanOpenWindowsAutomatically(true);
        mWebView.getSettings().setDomStorageEnabled(true);
        mWebView.getSettings().setJavaScriptCanOpenWindowsAutomatically(true);
        mWebView.getSettings().setBuiltInZoomControls(true);
        mWebView.getSettings().setAllowFileAccess(true);
        mWebView.getSettings().setSupportZoom(true);

        //mWebView.setWebChromeClient(new GeoWebChromeClient());



        ConnectivityInfo.init(this);
        boolean a = ConnectivityInfo.isConnected();
        if(!ConnectivityInfo.isConnected()) {


            new AlertDialog.Builder(new ContextThemeWrapper(MainActivity.this, R.style.AlertDialogCustomNovo))
                    //new AlertDialog.Builder(Splash.this )
                    .setTitle("Maria Judx")
                    .setCancelable(false)/* forca modal*/
                    .setMessage("Impossível prosseguir, falta uma conexão com a internet!")
                    /*.setPositiveButton("sim",
                            new DialogInterface.OnClickListener() {
                                @Override
                                public void onClick(DialogInterface dialogInterface, int i) {

                                }
                            })*/
                    .setNegativeButton("OK", new DialogInterface.OnClickListener() {
                        @Override
                        public void onClick(DialogInterface dialogInterface, int i) {
                            finish();
                            System.exit(0);
                        }
                    })
                    .show();

        }else{
            //Intent intent = getIntent();
            //GlobalUrl = intent.getExtras().getString("GlobalUrl");


            // Brower niceties -- pinch / zoom, follow links in place

            // Load google.com
            //mWebView.setWebViewClient(new WebViewClient());
            mWebView.setWebChromeClient(new WebChromeClient() {
                // Grant permissions for cam
                @Override
                public void onPermissionRequest(final PermissionRequest request) {
                    ///Log.d(TAG, "onPermissionRequest");
                    MainActivity.this.runOnUiThread(new Runnable() {
                        @TargetApi(Build.VERSION_CODES.M)
                        @Override
                        public void run() {
                            //Log.d(TAG, request.getOrigin().toString());
                            if(request.getOrigin().toString().equals("file:///")) {
                                //Log.d(TAG, "GRANTED");
                                request.grant(request.getResources());
                            } else {
                                //Log.d(TAG, "DENIED");
                                request.deny();
                            }
                        }
                    });
                }


            });
            mWebView.loadUrl(GlobalUrl);
        }



    }
}
