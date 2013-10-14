package com.derek.myruns;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStreamReader;
import java.io.UnsupportedEncodingException;
import java.util.ArrayList;
import java.util.List;

import org.apache.http.HttpResponse;
import org.apache.http.NameValuePair;
import org.apache.http.client.ClientProtocolException;
import org.apache.http.client.HttpClient;
import org.apache.http.client.entity.UrlEncodedFormEntity;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.impl.client.DefaultHttpClient;
import org.apache.http.message.BasicNameValuePair;

import android.annotation.TargetApi;
import android.content.Context;
import android.os.AsyncTask;
import android.os.Build;
import android.widget.Toast;

@TargetApi(Build.VERSION_CODES.CUPCAKE)
public class AddRunAsync extends AsyncTask<String, Void, String> {

	AddRun myCaller_;
	
	AddRunAsync( AddRun caller ) {
		myCaller_ = caller;
	}
	
	@Override
	protected String doInBackground(String... params) {
		// Params List:
		// 0 : uid
		// 1 : distance
		// 2 : time
		// 3 : month
		// 4 : day
		// 5 : year
		// 6 : unit
		
		HttpClient client = new DefaultHttpClient();
		HttpPost post = new HttpPost("http://www.myRuns.freeiz.com/androidAdd.php");
		
		List<NameValuePair> prms = new ArrayList<NameValuePair>(2);
		prms.add(new BasicNameValuePair("fromAndroid", "1")); 		// Tells server we are from android
		prms.add(new BasicNameValuePair("uid", params[0]));			// UID of the runner
		prms.add(new BasicNameValuePair("dist", params[1]));		// Distance of run
		prms.add(new BasicNameValuePair("time", params[2]));		// Run time (hh:mm:ss or mm:ss)
		prms.add(new BasicNameValuePair("rMon", params[3]));		// Month of run (1 to 12)
		prms.add(new BasicNameValuePair("rDay", params[4]));		// Day of run (1 to 31)
		prms.add(new BasicNameValuePair("rYear", params[5]));		// Year of run
		prms.add(new BasicNameValuePair("unit", params[6]));		// Multiples of km (km = 1, mi = 1.609)
			
		try {
			post.setEntity(new UrlEncodedFormEntity(prms));		// Encoded the parameters
			
			HttpResponse response = client.execute(post);
			BufferedReader reader = new BufferedReader(new InputStreamReader(response.getEntity().getContent()));
			
			StringBuilder sb = new StringBuilder();
			String line = null;
			while ((line = reader.readLine()) != null) {
				sb.append(line + "\n");
			}
			
			line = (String) sb.toString().subSequence(sb.toString().indexOf("<error>") + 7, sb.toString().indexOf("</error>"));
			return line;
			
			
		} catch (UnsupportedEncodingException e) {
			// Do nothing
		} catch (ClientProtocolException e) {
			// Do nothing
		} catch (IOException e) {
			// Do nothing
		}
		
		return null;
	}
	
	protected void onPostExecute(String str) {
		CharSequence text = null;
		if (str.matches("0")) { // No error
			text = "Run added successfully!";
		} else if (str.matches("1")) {
			text = "Could not read distance unit.";		// Very unlikely to happen unless the network corrupts the data
		} else if (str.matches("2")) {
			text = "Could not read time.";	// Could easily happen if the time is entered poorly.
		} else if (str.matches("3")) {
			text = "Could not connect to database";		// Has never happened using the web version
		} else if (str.matches("4")) {
			text = "SQL Error.";		// Also never happened.
		} else if (str.matches("5")) {
			text = "Unknown Error";
		} else {
			text = "Unknown Error: " + str;	// Not really sure what could fit here but best
											// To cover all the bases
		}
		
		Context context = myCaller_;
		int duration = Toast.LENGTH_SHORT;
		
		Toast.makeText(context, text, duration).show();
		
	}
	
}
