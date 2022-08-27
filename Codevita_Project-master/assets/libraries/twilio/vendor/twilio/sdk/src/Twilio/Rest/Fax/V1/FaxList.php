<?php

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0
 * /       /
 */

namespace Twilio\Rest\Fax\V1;

use Twilio\Exceptions\TwilioException;
use Twilio\ListResource;
use Twilio\Options;
use Twilio\Serialize;
use Twilio\Values;
use Twilio\Version;

/**
 * PLEASE NOTE that this class contains beta products that are subject to change. Use them with caution.
 */
class FaxList extends ListResource {
    /**
     * Construct the FaxList
     *
     * @param Version $version Version that contains the resource
     * @return \Twilio\Rest\Fax\V1\FaxList
     */
    public function __construct(Version $version) {
        parent::__construct($version);

        // Path Solution
        $this->solution = array();

        $this->uri = '/Faxes';
    }

    /**
     * Streams FaxInstance records from the API as a generator stream.
     * This operation lazily loads records as efficiently as possible until the
     * limit
     * is reached.
     * The results are returned as a generator, so this operation is memory
     * efficient.
     *
     * @param array|Options $options Optional Arguments
     * @param int $limit Upper limit for the number of records to return. stream()
     *                   guarantees to never return more than limit.  Default is no
     *                   limit
     * @param mixed $pageSize Number of records to fetch per request, when not set
     *                        will use the default value of 50 records.  If no
     *                        page_size is defined but a limit is defined, stream()
     *                        will attempt to read the limit with the most
     *                        efficient page size, i.e. min(limit, 1000)
     * @return \Twilio\Stream stream of results
     */
    public function stream($options = array(), $limit = null, $pageSize = null) {
        $limits = $this->version->readLimits($limit, $pageSize);

        $page = $this->page($options, $limits['pageSize']);

        return $this->version->stream($page, $limits['limit'], $limits['pageLimit']);
    }

    /**
     * Reads FaxInstance records from the API as a list.
     * Unlike stream(), this operation is eager and will load `limit` records into
     * memory before returning.
     *
     * @param array|Options $options Optional Arguments
     * @param int $limit Upper limit for the number of records to return. read()
     *                   guarantees to never return more than limit.  Default is no
     *                   limit
     * @param mixed $pageSize Number of records to fetch per request, when not set
     *                        will use the default value of 50 records.  If no
     *                        page_size is defined but a limit is defined, read()
     *                        will attempt to read the limit with the most
     *                        efficient page size, i.e. min(limit, 1000)
     * @return FaxInstance[] Array of results
     */
    public function read($options = array(), $limit = null, $pageSize = null) {
        return iterator_to_array($this->stream($options, $limit, $pageSize), false);
    }

    /**
     * Retrieve a single page of FaxInstance records from the API.
     * Request is executed immediately
     *
     * @param array|Options $options Optional Arguments
     * @param mixed $pageSize Number of records to return, defaults to 50
     * @param string $pageToken PageToken provided by the API
     * @param mixed $pageNumber Page Number, this value is simply for client state
     * @return \Twilio\Page Page of FaxInstance
     */
    public function page($options = array(), $pageSize = Values::NONE, $pageToken = Values::NONE, $pageNumber = Values::NONE) {
        $options = new Values($options);
        $params = Values::of(array(
            'From' => $options['from'],
            'To' => $options['to'],
            'DateCreatedOnOrBefore' => Serialize::iso8601DateTime($options['dateCreatedOnOrBefore']),
            'DateCreatedAfter' => Serialize::iso8601DateTime($options['dateCreatedAfter']),
            'PageToken' => $pageToken,
            'Page' => $pageNumber,
            'PageSize' => $pageSize,
        ));

        $response = $this->version->page(
            'GET',
            $this->uri,
            $params
        );

        return new FaxPage($this->version, $response, $this->solution);
    }

    /**
     * Retrieve a specific page of FaxInstance records from the API.
     * Request is executed immediately
     *
     * @param string $targetUrl API-generated URL for the requested results page
     * @return \Twilio\Page Page of FaxInstance
     */
    public function getPage($targetUrl) {
        $response = $this->version->getDomain()->getClient()->request(
            'GET',
            $targetUrl
        );

        return new FaxPage($this->version, $response, $this->solution);
    }

    /**
     * Create a new FaxInstance
     *
     * @param string $to The phone number to receive the fax
     * @param string $mediaUrl The URL of the PDF that contains the fax
     * @param array|Options $options Optional Arguments
     * @return FaxInstance Newly created FaxInstance
     * @throws TwilioException When an HTTP error occurs.
     */
    public function create($to, $mediaUrl, $options = array()) {
        $options = new Values($options);

        $data = Values::of(array(
            'To' => $to,
            'MediaUrl' => $mediaUrl,
            'Quality' => $options['quality'],
            'StatusCallback' => $options['statusCallback'],
            'From' => $options['from'],
            'SipAuthUsername' => $options['sipAuthUsername'],
            'SipAuthPassword' => $options['sipAuthPassword'],
            'StoreMedia' => Serialize::booleanToString($options['storeMedia']),
            'Ttl' => $options['ttl'],
        ));

        $payload = $this->version->create(
            'POST',
            $this->uri,
            array(),
            $data
        );

        return new FaxInstance($this->version, $payload);
    }

    /**
     * Constructs a FaxContext
     *
     * @param string $sid The unique string that identifies the resource
     * @return \Twilio\Rest\Fax\V1\FaxContext
     */
    public function getContext($sid) {
        return new FaxContext($this->version, $sid);
    }

    /**
     * Provide a friendly representation
     *
     * @return string Machine friendly representation
     */
    public function __toString() {
        return '[Twilio.Fax.V1.FaxList]';
    }
}